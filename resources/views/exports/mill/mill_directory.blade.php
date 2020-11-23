<?php
    
function countMillRegPerRegion($mill_registrations, $region){

    $count = 0;

    foreach($mill_registrations as $data){
        if (!empty($data->mill)){
            if ($data->mill->report_region == $region){
                $count =+ 1;
            }
        }
    }

    return $count;

}

?>

<table>

    <thead style="padding-top:100px;">

      <tr>
        <td colspan="4" style="text-align: center;">
          DIRECTORY OF SUGAR MILLS
        </td>
      </tr>
        
      <tr>
        <td colspan="4" style="text-align: center;">CROP YEAR {{ $crop_year->name }}</td>
      </tr>
        
      <tr>
        <td colspan="4">&nbsp;</td>
      </tr>

      <tr>
        <th style="width:40px; font-size:9px; font-weight: bold; border-top: 1px solid black; border-bottom: 1px solid black;">SUGAR MILLS</th>
        <th style="width:40px; font-size:9px; font-weight: bold; border-top: 1px solid black; border-bottom: 1px solid black;">METRO MANILA ADDRESS</th>
        <th style="width:40px; font-size:9px; font-weight: bold; border-top: 1px solid black; border-bottom: 1px solid black;">MILL SITE ADDRESS</th>
        <th style="width:40px; font-size:9px; font-weight: bold; border-top: 1px solid black; border-bottom: 1px solid black;">OFFICIAL / EMAIL ADDRESS</th>
      </tr>

    </thead>

    <tbody>

    @foreach (__static::report_regions() as $rr_name => $rr_key)

        @if (countMillRegPerRegion($mill_registrations, $rr_key) > 0)
          
            <?php $i = 0; ?>

            <tr>
                <td colspan="4"></td>
            </tr>
            <tr>
                <td colspan="4" style="text-align: center; font-size: 14px; font-weight: bold;">
                    {{ $rr_name }}
                </td>
            </tr>
            <tr>
                <td colspan="4"></td>
            </tr>

            @foreach($mill_registrations as $data)
                @if (!empty($data->mill))
                    @if ($data->mill->report_region == $rr_key)
                        <tr>
                            <td style="vertical-align:top; font-size:9px; width:22px; border:1px solid black;">
                                {{ $i += 1 }}. {{ optional($data->mill)->name }}<br>
                                {{ optional(optional($data->mill)->region)->name }}
                            </td>
                            <td style="vertical-align:top; font-size:9px; width:22px; border:1px solid black;">
                                {{ optional($data->mill)->address }}<br>
                                {{ optional($data->mill)->tel_no }}<br>
                                {{ optional($data->mill)->fax_no }}<br>
                            </td>
                            <td style="vertical-align:top; font-size:9px; width:22px; border:1px solid black;">
                                {{ optional($data->mill)->address_second }}<br>
                                {{ optional($data->mill)->tel_no_second }}<br>
                                {{ optional($data->mill)->fax_no_second }}<br>
                            </td>
                            <td style="vertical-align:top; font-size:9px; width:22px; border:1px solid black;">
                                {{ optional($data->mill)->officer }} - {{ optional($data->mill)->position }}<br>
                                {{ optional($data->mill)->email }}
                            </td>
                        </tr>
                    @endif
                @endif
            @endforeach

        @endif

    @endforeach

    </tbody>

</table>