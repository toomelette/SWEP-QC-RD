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
        <td colspan="2" style="text-align: center;">
          REFINERY RATED CAPACITY
        </td>
      </tr>
        
      <tr>
        <td colspan="2" style="text-align: center;">CROP YEAR {{ $crop_year->name }}</td>
      </tr>
        
      <tr>
        <td colspan="2">&nbsp;</td>
      </tr>

      <tr style="border:1px solid black;">
        <th style="width:40px; font-weight: bold;">
            SUGAR REFINERIES
        </th>
        <th style="width:40px; font-weight: bold;">
            RATED CAPACITY
        </th>
      </tr>

    </thead>

    <tbody>

    <?php 
        $total_L = 0;
        $total_V = 0;
        $total_M = 0; 
    ?>

    @foreach (__static::report_regions() as $rr_name => $rr_key)

        @if (countMillRegPerRegion($refinery_registrations, $rr_key) > 0)
          
            <?php $i = 0; ?>
            
            <tr>
                <td style="font-weight: bold; border:1px solid black;">
                    {{ $rr_name }}
                </td>
                <td style="border:1px solid black;"></td>
            </tr>

            @foreach($refinery_registrations as $data)
                @if (!empty($data->refinery))
                    @if ($data->refinery->report_region == $rr_key)

                        <?php $total_L += $data->rated_capacity ?>

                        <tr>
                            <td style="vertical-align:top; width:40px; word-wrap: break-word; border:1px solid black;">
                                {{ optional($data->refinery)->name }}
                            </td>
                            <td style="vertical-align:top; width:40px; word-wrap: break-word; border:1px solid black;">
                                {{ number_format($data->rated_capacity, 2) }} Lkg/day
                            </td>
                        </tr>

                    @endif
                @endif
            @endforeach

        @endif

    @endforeach

    <?php
      $total_rc = $total_L + $total_V + $total_M;
    ?>

    <tr>
        <td style="vertical-align: top; font-weight:bold; border:1px solid black;">
            TOTAL
        </td>
        <td style="vertical-align: top; font-weight:bold; border:1px solid black;">
            {{ number_format($total_rc, 2) }}
        </td>
    </tr>

    </tbody>

</table>