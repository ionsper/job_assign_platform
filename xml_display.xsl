<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
<xsl:template match="/">
<html>
<body>
    <table align="center" border="2">
        <!-- Αριθμός ομάδων -->
        <tr align="center">
            <th>
                Αριθμός των ομάδων:
            </th>
            <td>
            <xsl:value-of select="count(/info/omades)"/>
            </td>
        </tr>
        <!-- Χρήστες ανα ομάδα -->
        <tr align="center">
            <td>
            Χρήστες ανα ομάδα
            </td>      
        </tr>
        <tr>
                <td align="center">
                    <b>Ομάδα</b>
                </td>
                <td align="center">
                   <b>Χρήστες</b>
                </td>
        </tr>
        <xsl:for-each select="info/omades" align="center">
        <tr>
            <td align="center">
                <xsl:value-of select="onoma_omadas"/>
            </td>
            <td align="center">
                <xsl:value-of select="count(users)"/>
            </td>
        </tr>
        </xsl:for-each>
        <!-- Περισσότερα Μέλη -->
        <tr>
        <td align="center">
                    <b>Περισσότερα Μέλη</b>
            </td>
            <td>
                <xsl:for-each select="info/omades">
                    <xsl:sort select="count(users)" data-type="number" order="descending"/>
                    <xsl:if test="position()=1">
                        <xsl:value-of select="onoma_omadas"/>
                    </xsl:if>
                </xsl:for-each>
            </td>
        </tr>
        <!-- Λιγότερα Μέλη -->
        <tr>
        <td align="center">
                    <b>Λιγότερα Μέλη</b>
            </td>
            <td>
                <xsl:for-each select="info/omades">
                    <xsl:sort select="count(users)" data-type="number" order="ascending"/>
                    <xsl:if test="position()=1">
                        <xsl:value-of select="onoma_omadas"/>
                    </xsl:if>
                </xsl:for-each>
            </td>
        </tr>
        <!-- Σύνολο Λιστών -->
        <tr>
            <td align="center">
                    <b>Σύνολο Λιστών</b>
            </td>
            <td align="center">
                <xsl:value-of select="count(/info/omades/lists)"/>
            </td>
        </tr>
        <!-- Νέες Λίστες -->
        <tr>
            <td align="center">
                    <b>Νέες Λίστες</b>
            </td>
            <td align="center">
                <xsl:variable name="exelixi" select="count(info/omades/lists[contains(status, 'Νέα')])"/>
                <xsl:value-of select="$exelixi"/>
            </td>
        </tr>
        <!-- Λίστες σε εξέλιξη -->
        <tr>
            <td align="center">
                    <b>Λίστες σε εξέλιξη</b>
            </td>
            <td align="center">
                <xsl:variable name="exelixi" select="count(info/omades/lists[contains(status, 'Σε εξέλιξη')])"/>
                <xsl:value-of select="$exelixi"/>
            </td>
        </tr>
        <!-- Ολοκληρωμένες Λίστες ανα ομάδα -->
        <tr align="center">
            <td>
            Ολοκληρωμένες Λίστες
            </td>      
        </tr>
        <tr>
                <td align="center">
                    <b>Ομάδα</b>
                </td>
                <td align="center">
                   <b>Λίστες</b>
                </td>
        </tr>
        <xsl:for-each select="info/omades" align="center">
        <tr>
            <td align="center">
                <xsl:value-of select="onoma_omadas"/>
            </td>
            <td align="center">
                <xsl:variable name="olokliromenes" select="count(lists[status='Ολοκληρωμένη'])"/>
                <xsl:value-of select="$olokliromenes"/>   
            </td>
        </tr>
        </xsl:for-each>

    </table>
</body>
</html>
</xsl:template>
</xsl:stylesheet>