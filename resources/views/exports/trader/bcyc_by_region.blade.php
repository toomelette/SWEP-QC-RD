<?php
    
    $cat = [

    'TC1001' => 'DOMESTIC SUGAR TRADERS',
    'TC1002' => 'INTERNATIONAL SUGAR TRADERS',
    'TC1003' => 'DOMESTIC MOLASSES TRADERS',
    'TC1004' => 'INTERNATIONAL MOLASSES TRADERS',
    'TC1005' => 'MUSCOVADO TRADER',
    'TC1006' => 'INTERNATIONAL SUGAR (FRUCTOSE) TRADER',

  ];

  $trader_registrations_array = $trader_registrations->pluck('trader.region_id')->toArray();

?>
<table>

    <thead style="display: table-header-group;">
        
      <tr>
        <td colspan="4" style="text-align: center;">
          LISTING OF REGISTERED {{ $cat[$request->bcyc_tc] }}
        </td>
      </tr>
        
      <tr>
        <td colspan="4" style="text-align: center;">CROP YEAR {{ $crop_year->name }}</td>
      </tr>
        
      <tr>
        <td colspan="4">&nbsp;</td>
      </tr>

      <tr>
        <th style="width:3px; text-align: center; font-weight: bold; border-top: 1px solid black; border-bottom: 1px solid black;">#</th>
        <th style="width:45px; font-weight: bold; border-top: 1px solid black; border-bottom: 1px solid black;">NAME &amp; ADDRESS</th>
        <th style="width:20px; text-align: center; font-weight: bold; border-top: 1px solid black; border-bottom: 1px solid black;">TIN</th>
        <th style="width:20px; text-align: center; font-weight: bold; border-top: 1px solid black; border-bottom: 1px solid black;">TEL. NO. / FAX NO.</th>
      </tr>

    </thead>

    <tbody>

      @foreach ($global_regions_all as $region_data)

        <?php $i = 0; ?>

        @if (in_array($region_data->region_id, $trader_registrations_array))

          <tr>
            <td colspan="4"></td>
          </tr>

          <tr>
            <td colspan="4" style="text-align: center; font-size: 15px;">
              {{ $region_data->name }}
            </td>
          </tr>

          <tr>
            <td colspan="4"></td>
          </tr>

          @foreach($trader_registrations as $key => $tr_data)

            <tr>
              <td style="width:3px; text-align: center; vertical-align: top; font-size: 11px;">
                {{ $i += 1 }}
              </td>
              <td style="width:45px; font-size: 11px;">
                {{ optional($tr_data->trader)->name }}<br>
                {{ optional($tr_data->trader)->address }}<br>
                {{ $tr_data->trader_officer }}<br>
                {{ $tr_data->trader_email }}<br>
              </td>
              <td style="width:20px; text-align: center; vertical-align: top; font-size: 11px;">
                  {{ optional($tr_data->trader)->tin }}
              </td>
              <td style="width:20px; text-align: center; vertical-align: top; font-size: 11px;">
                  {{ optional($tr_data->trader)->tel_no }}
              </td>
            </tr>

          @endforeach

        @endif

      @endforeach

    </tbody>

</table>