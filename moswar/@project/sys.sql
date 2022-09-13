DROP FUNCTION IF EXISTS <%db%>.checkUserRightsOnObject
$$

CREATE
DEFINER = '<%user%>'@'<%host%>'
FUNCTION <%db%>.checkUserRightsOnObject(metaObjectId INT, objectId INT, sysuserID INT, requiredRights INT)
RETURNS INT
BEGIN
    DECLARE myRights INT;
    CALL checkUserRightsOnObjectRecursive(metaObjectId, objectId, sysuserID, requiredRights, myRights);
    IF (myRights & requiredRights) THEN
        RETURN 1;
    ELSE
        RETURN 0;
    END IF;
END
$$

DROP PROCEDURE IF EXISTS <%db%>.checkUserRightsOnObjectRecursive
$$

CREATE
DEFINER = '<%user%>'@'<%host%>'
PROCEDURE <%db%>.checkUserRightsOnObjectRecursive(metaObjectId INT, objectId INT, sysuserId INT, requiredRights INT, OUT myRights INT)
BEGIN
    DECLARE query VARCHAR(255);
    DECLARE metaObjectCode VARCHAR(255);
    DECLARE curParent INT;
    DECLARE curParentCode VARCHAR(255);
    DECLARE curParentObjectId INT;
    DECLARE done INT DEFAULT 0;
    DECLARE linkMetaAttributeCode VARCHAR(255);
    DECLARE parentId INT;
    DECLARE parents CURSOR FOR
        SELECT mo.id, mo.code
        FROM metaobject mo
            LEFT JOIN metarelation mr ON mr.from = mo.id
        WHERE mr.to = metaObjectId AND mr.type=1;
    DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = 1;

    body:
    BEGIN
        SELECT code INTO metaObjectCode
            FROM metaobject
            WHERE id=metaObjectId;
        SELECT rights INTO myRights
            FROM syssecurity
            WHERE metaobject_id = metaObjectId AND metaview_id = 0 AND (object_id = 0 OR object_id = objectId)
            ORDER BY rights DESC
            LIMIT 0,1;
        IF (myRights & requiredRights) THEN
            OPEN parents;

            REPEAT
                FETCH parents INTO curParent, curParentCode;
                IF NOT done THEN
                    SET curParentObjectId = getParentId(metaObjectCode, curParentCode, objectId);
                    CALL checkUserRightsOnObjectRecursive(curParent, curParentObjectId, sysuserId, requiredRights, myRights);
                    IF !(myRights & requiredRights) THEN
                        CLOSE parents;
                        LEAVE body;
                    END IF;
                END IF;
            UNTIL done END REPEAT;

            CLOSE parents;
        ELSE
            SET myRights = 0;
        END IF;
    END body;
END
$$

DROP FUNCTION IF EXISTS <%db%>.getParentId
$$

CREATE
DEFINER = '<%user%>'@'<%host%>'
FUNCTION <%db%>.getParentId(metaObjectCode VARCHAR(255), parentMetaObjectCode VARCHAR(255), objectId INT)
RETURNS INT
BEGIN
    DECLARE parentId INT;
    <%get_parent_id%>
    return parentId;
END
$$
