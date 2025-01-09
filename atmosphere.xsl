<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
    <xsl:output method="html" indent="yes" encoding="UTF-8"/>
    
    <xsl:template match="/">
        <!-- Seulement le jour actuel -->
        <xsl:apply-templates select="//echeance[substring(@timestamp, 1, 10) = $current_date]" /> 
    </xsl:template>

    <xsl:template match="echeance">
        <div class="periode" id="{position()}">
            <h2><xsl:value-of select="substring(@timestamp, 12, 2)" />H </h2>           

            <!-- Pluie -->
            <xsl:choose>
                <xsl:when test="pluie &gt; 0">
                    <p class="symbol">🌧️</p>
                </xsl:when>
                <xsl:otherwise>
                    <p class="symbol">☀️</p>
                </xsl:otherwise>
            </xsl:choose>           

            <!-- Vent-->
            <xsl:variable name="vent" select="vent_moyen/level[@val='10m']"/>
            <p> 
                <xsl:choose>
                    <xsl:when test="$vent &lt; 2.8">
                        <p class="symbol">🍃</p>
                    </xsl:when>
                    <xsl:when test="$vent &lt; 10">
                        <p class="symbol">🌬️</p> 
                    </xsl:when>
                    <xsl:otherwise>
                        <p class="symbol">💨</p>
                    </xsl:otherwise>
                </xsl:choose>
            </p>

            <!-- Risque de neige -->
            <xsl:choose>
                <xsl:when test="risque_neige = 'oui'">
                    <p class="symbol">❄️</p>
                </xsl:when>
                <xsl:otherwise>
                    <p class="symbol">🌤️</p>
                </xsl:otherwise>
            </xsl:choose>
            
            <!-- Température -->
            <p class="temperature"><xsl:value-of select="floor(number(temperature/level[@val='2m']) - 273.15)"/>°C</p>
        </div>
    </xsl:template>
</xsl:stylesheet>
