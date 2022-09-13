drop event if exists ev_dropgifts;
$$
create event ev_dropgifts on schedule every 1 hour ON COMPLETION PRESERVE DO BEGIN
    delete from gift where endtime<UNIX_TIMESTAMP(NOW()) and endtime != 0 and type = 'gift';
end;
$$

drop event if exists ev_offplayboy;
$$
CREATE EVENT ev_offplayboy ON SCHEDULE EVERY 30 MINUTE ON COMPLETION PRESERVE ENABLE DO BEGIN
    IF (minute(now()) > 1) THEN
        UPDATE player SET playboy = 0 WHERE playboy = 1 AND playboytime < unix_timestamp(now());
    END IF;
END;
$$

drop event if exists ev_endpolice;
$$
CREATE EVENT ev_endpolice ON SCHEDULE EVERY 1 MINUTE ON COMPLETION PRESERVE ENABLE DO BEGIN
    IF (minute(now()) > 1) THEN
        UPDATE player SET suspicion = -5, state = '', homesalarytime = UNIX_TIMESTAMP(CONCAT(CURDATE(), ' ', MAKETIME(HOUR(NOW()), 0, 0))) WHERE state = 'police' AND timer < unix_timestamp(now());
    END IF;
END;
$$

drop event if exists ev_clearchatlog;
$$
create event ev_clearchatlog on schedule every 10 minute ON COMPLETION PRESERVE DO BEGIN
    delete from chatlog where time < unix_timestamp(now()) - 600;
end;
$$

drop event if exists ev_setoffline;
$$

drop event if exists ev_homesalary;
$$

drop event if exists ev_suspicion;
$$

drop event if exists ev_rating_player;
$$

drop event if exists ev_rating_clan;
$$

drop event if exists ev_rating_fraction;
$$

drop event if exists ev_endwork;
$$

drop trigger if exists rating_clan_create;
$$

drop trigger if exists rating_player_create;
$$

drop trigger if exists rating_player_drop;
$$

drop trigger if exists rating_clan_drop;
$$

drop trigger if exists player_finishstat;
$$

drop trigger if exists player_rating_changefraction;
$$

drop trigger if exists playerboost_insert;
$$

drop trigger if exists playerboost_drop;
$$

drop trigger if exists inventory_drop;
$$

drop trigger if exists inventory_update;
$$

drop trigger if exists playerwork_drop;
$$