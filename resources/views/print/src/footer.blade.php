<div id="footer">
	<hr>
	<table style="font-size:12px;">
        <tr >
            <td style="border-right:1px solid"  width="20%"><b> Consultado por: </b></td>
            <td  style="text-align:left;">
                {{ Auth::user()->person->last_name }} {{ Auth::user()->person->name }}
			</td>
        </tr>
        <tr>
            <td style="border-right:1px solid"  width="20%"><b> Fecha / Hora:</b></td>
            <td>
                <?php 
                    $dt = new DateTime(); 
                    echo $dt->format('Y/m/d H:i:s'); 
                ?>
            </td>
        </tr>
    </table>
</div>

