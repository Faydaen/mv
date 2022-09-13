<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
    <xsl:output method="html"/>

    <xsl:include href="common/actlink.xsl" />
    
    <xsl:key name="actbyid" match="element" use="id" />

    <xsl:template match="/data">
        <xsl:for-each select="log/element">
            <xsl:choose>
                <!--xsl:when test="/data/page > 0 and current()/element[1] > 0"-->
                <xsl:when test="/data/page > 0">
                    <p>
                        <xsl:choose>
                            <xsl:when test="current()/element[1] = 0 and current()/element[2]/element[1] = 1">
                                <xsl:attribute name="class">killed</xsl:attribute>
                            </xsl:when>
                            <xsl:when test="current()/element[3]/element[1] = 2">
                                <xsl:attribute name="class">critical</xsl:attribute>
                            </xsl:when>
                            <xsl:when test="current()/element[1] = 0 and current()/element[2]/element[1] = 2">
                                <xsl:attribute name="class">flag</xsl:attribute>
                            </xsl:when>
                            <!--xsl:when test="current()/element[7] = 1">
                                <xsl:attribute name="class">me</xsl:attribute>
                            </xsl:when>
                            <xsl:when test="current()/element[7] = 2">
                                <xsl:attribute name="class">me2</xsl:attribute>
                            </xsl:when-->
                            <xsl:when test="current()/element[1] = 0 and current()/element[2]/element[1] = 5">
                                <xsl:attribute name="class">forcejoin</xsl:attribute>
                            </xsl:when>
                            <xsl:when test="current()/element[1] = 0 and current()/element[2]/element[1] = 6">
                                <xsl:attribute name="class">heal</xsl:attribute>
                            </xsl:when>
                            <xsl:when test="current()/element[1] = 0 and current()/element[2]/element[1] = 7">
                                <xsl:attribute name="class">use</xsl:attribute>
                            </xsl:when>
                            <xsl:when test="current()/element[1] = 0 and current()/element[2]/element[1] = 8">
                                <xsl:attribute name="class">rupor</xsl:attribute>
                            </xsl:when>
                            <xsl:when test="current()/element[1] = 0 and current()/element[2]/element[1] = 9">
                                <xsl:attribute name="class">bang-throw</xsl:attribute>
                            </xsl:when>
                            <xsl:when test="current()/element[1] = 0 and current()/element[2]/element[1] = 10">
                                <xsl:attribute name="class">bang</xsl:attribute>
                            </xsl:when>
							<xsl:when test="current()/element[1] = 0 and current()/element[2]/element[1] = 11">
                                <xsl:attribute name="class">helmet</xsl:attribute>
                            </xsl:when>
							<xsl:when test="current()/element[1] = 0 and current()/element[2]/element[1] = 12">
                                <xsl:attribute name="class">reflect</xsl:attribute>
                            </xsl:when>
							<xsl:when test="current()/element[1] = 0 and current()/element[2]/element[1] = 13">
                                <xsl:attribute name="class">cheese</xsl:attribute>
                            </xsl:when>
							<xsl:when test="current()/element[1] = 0 and current()/element[2]/element[1] = 14">
                                <xsl:attribute name="class">antigranata</xsl:attribute>
                            </xsl:when>
                        </xsl:choose>
						<xsl:if test="current()/element[1] = 0 and current()/element[2]/element[1] = 2">
                            <span class="icon icon-flag"></span>
                        </xsl:if>
						<xsl:if test="current()/element[1] = 0 and current()/element[2]/element[1] = 5">
                            <span class="icon icon-forcejoin"></span>
                        </xsl:if>
                        <xsl:if test="current()/element[3]/element[3] > 1">
                            <span class="icon serial"><xsl:value-of select="current()/element[3]/element[3]" /></span>
                        </xsl:if>
                        <xsl:if test="current()/element[1] = 0 and current()/element[2]/element[1] = 4">
                            <span class="icon shield"></span>
                        </xsl:if>
						<xsl:if test="current()/element[1] = 0 and current()/element[2]/element[1] = 6">
                            <span class="icon icon-heal"></span>
                        </xsl:if>
						<xsl:if test="current()/element[1] = 0 and current()/element[2]/element[1] = 8">
                            <span class="icon icon-rupor"></span>
                        </xsl:if>
						<xsl:if test="current()/element[1] = 0 and current()/element[2]/element[1] = 10">
                            <span class="icon icon-bang"></span>
                        </xsl:if>
						<xsl:if test="current()/element[1] = 0 and current()/element[2]/element[1] = 11">
                            <span class="icon icon-helmet"></span>
                        </xsl:if>
						<xsl:if test="current()/element[1] = 0 and current()/element[2]/element[1] = 12">
                            <span class="icon icon-reflect"></span>
                        </xsl:if>
						<xsl:if test="current()/element[1] = 0 and current()/element[2]/element[1] = 13">
                            <span class="icon icon-cheese"></span>
                        </xsl:if>
						<xsl:if test="current()/element[1] = 0 and current()/element[2]/element[1] = 13">
                            <span class="icon icon-antigranata"></span>
                        </xsl:if>
                        <xsl:choose>
                            <xsl:when test="current()/element[1] = 0">
                                <xsl:for-each select="current()/element[4]/element">
                                    <xsl:choose>
                                        <xsl:when test="current() = '1'">
                                            <xsl:call-template name="actlink">
                                                <xsl:with-param name="act" select="../../element[5]" />
                                            </xsl:call-template>
                                        </xsl:when>
                                        <xsl:when test="current() = '2'">
                                            <xsl:call-template name="actlink">
                                                <xsl:with-param name="act" select="../../element[6]" />
                                            </xsl:call-template>
                                        </xsl:when>
                                        <xsl:otherwise><xsl:value-of select="current()" disable-output-escaping="yes" /></xsl:otherwise>
                                    </xsl:choose>
                                </xsl:for-each>
                            </xsl:when>
                            <xsl:otherwise>
                                <xsl:choose>
									<xsl:when test="current()/element[3]/element[1] = 14">
										<xsl:call-template name="actlink">
											<xsl:with-param name="act" select="current()/element[6]" />
										</xsl:call-template>
										<span class="reflected">отпружинивает удар</span>
										<xsl:call-template name="actlink">
											<xsl:with-param name="act" select="current()/element[5]" />
										</xsl:call-template>
									</xsl:when>
									<xsl:otherwise>
										<xsl:call-template name="actlink">
											<xsl:with-param name="act" select="current()/element[5]" />
										</xsl:call-template>
										<xsl:choose>
											<xsl:when test="current()/element[3]/element[1] = 1 or current()/element[3]/element[1] = 2 or current()/element[3]/element[1] = 3"><span class="punch">бьёт</span></xsl:when>
											<xsl:when test="current()/element[3]/element[1] = 11"><span class="heal">лечит</span></xsl:when>
											<xsl:when test="current()/element[3]/element[1] = 12"><span class="use">использует</span></xsl:when>
											<xsl:when test="current()/element[3]/element[1] = 13"><span class="helmethit">бьет по каске</span></xsl:when>
											<!-- <xsl:when test="current()/element[3]/element[1] = 14"><span class="reflected">напарывается на пружину</span></xsl:when> -->
											<xsl:when test="current()/element[3]/element[1] = 50 and current()/element[3]/element[2] > 0"><span class='punch'>прицеливается</span> и нападает на игрока&#160;</xsl:when>
											<xsl:when test="current()/element[3]/element[1] = 51 and current()/element[3]/element[2] > 0"><span class='miss'>перехватывает атаку</span></xsl:when>
											<xsl:otherwise><span class="miss">не попадает по</span></xsl:otherwise>
										</xsl:choose>
										<xsl:call-template name="actlink">
											<xsl:with-param name="act" select="current()/element[6]" />
										</xsl:call-template>
									</xsl:otherwise>
								</xsl:choose>
                            </xsl:otherwise>
                        </xsl:choose>
                        <xsl:if test="current()/element[3]/element[1] != 52 and count(current()/element[3]/element[2]) = 1 and current()/element[3]/element[2] > 0"> (-<xsl:value-of select="current()/element[3]/element[2]" />)</xsl:if>
                        <xsl:if test="current()/element[8] = 1">
                            <p class="line"><spacer/></p>
                        </xsl:if>
                    </p>
                </xsl:when>
                <xsl:when test="current()/element[1] = 0 and current()/element[3]/element[1] = 11 and /data/page = 0">
                    <p><xsl:call-template name="actlink">
                            <xsl:with-param name="act" select="key('actbyid', current()/element[2]/element[2])" />
                        </xsl:call-template> убил <xsl:value-of select="current()/element[2]/element[3]" /> игроков.</p>
                </xsl:when>
                <xsl:when test="current()/element[1] = 0 and current()/element[3]/element[1] = 12 and /data/page = 0">
                    <p><xsl:call-template name="actlink">
                            <xsl:with-param name="act" select="key('actbyid', current()/element[2]/element[2])" />
                        </xsl:call-template> нанес <xsl:value-of select="current()/element[2]/element[3]" /> урона.</p>
                </xsl:when>
            </xsl:choose>
        </xsl:for-each>
    </xsl:template>

</xsl:stylesheet>