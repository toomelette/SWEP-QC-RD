<?php
    
function countMillRegPerRegion($refinery_registrations, $region){

    $count = 0;

    foreach($refinery_registrations as $data){
        if (!empty($data->refinery)){
            if ($data->refinery->report_region == $region){
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
        <td colspan="5" style="text-align: center;">
          DIRECTORY OF SUGAR REFINERIES
        </td>
      </tr>
        
      <tr>
        <td colspan="5" style="text-align: center;">CROP YEAR {{ $crop_year->name }}</td>
      </tr>
        
      <tr>
        <td colspan="5">&nbsp;</td>
      </tr>

      <tr>
        <th style="width:19px; font-size:9px; font-weight: bold; border-top: 1px solid black; border-bottom: 1px solid black; text-align:center;">
            SUGAR <br>REFINERIES
        </th>
        <th style="width:9px; font-size:9px; font-weight: bold; border-top: 1px solid black; border-bottom: 1px solid black; text-align:center; ">
            RATED <br>CAPACITY
        </th>
        <th style="width:19px; font-size:9px; font-weight: bold; border-top: 1px solid black; border-bottom: 1px solid black; text-align:center;">
            METRO MANILA <br>ADDRESS
        </th>
        <th style="width:19px; font-size:9px; font-weight: bold; border-top: 1px solid black; border-bottom: 1px solid black; text-align:center;">
            MILL SITE <br>ADDRESS
        </th>
        <th style="width:19px; font-size:9px; font-weight: bold; border-top: 1px solid black; border-bottom: 1px solid black; text-align:center;">
            OFFICIAL / <br>EMAIL ADDRESS
        </th>
      </tr>

    </thead>

    <tbody>

    @foreach (__static::report_regions() as $rr_name => $rr_key)

        @if (countMillRegPerRegion($refinery_registrations, $rr_key) > 0)
          
            <?php $i = 0; ?>

            <tr>
                <td colspan="5"></td>
            </tr>
            <tr>
                <td colspan="5" style="text-align: center; font-size: 14px; font-weight: bold;">
                    {{ $rr_name }}
                </td>
            </tr>
            <tr>
                <td colspan="5"></td>
            </tr>

            @foreach($refinery_registrations as $data)
                @if (!empty($data->refinery))
                    @if ($data->refinery->report_region == $rr_key)
                        <tr>
                            <td style="vertical-align:top; font-size:9px; width:19px; border:1px solid black;">
                              {{ $i += 1 }}. {{ optional($data->refinery)->name }}<br>
                              {{ optional(optional($data->refinery)->region)->name }}
                            </td>
                            <td style="vertical-align:top; font-size:9px; width:9px; border:1px solid black;">
                              {{ number_format($data->rated_capacity, 2)  }}
                            </td>
                            <td style="vertical-align:top; font-size:9px; width:19px; border:1px solid black;">
                              {{ optional($data->refinery)->address }}<br>
                              {{ optional($data->refinery)->tel_no }}<br>
                              {{ optional($data->refinery)->fax_no }}<br>
                            </td>
                            <td style="vertical-align:top; font-size:9px; width:19px; border:1px solid black;">
                              {{ optional($data->refinery)->address_second }}<br>
                              {{ optional($data->refinery)->tel_no_second }}<br>
                              {{ optional($data->refinery)->fax_no_second }}<br>
                            </td>
                            <td style="vertical-align:top; font-size:9px; width:19px; border:1px solid black;">
                              {{ optional($data->refinery)->officer }} - {{ optional($data->refinery)->position }}<br>
                              {{ optional($data->refinery)->email }}
                            </td>
                        </tr>
                    @endif
                @endif
            @endforeach

        @endif

    @endforeach

    </tbody>

</table>