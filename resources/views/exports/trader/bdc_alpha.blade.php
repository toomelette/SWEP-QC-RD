<?php

  $cat = [

    'TC1001' => 'DOMESTIC SUGAR TRADERS',
    'TC1002' => 'INTERNATIONAL SUGAR TRADERS',
    'TC1003' => 'DOMESTIC MOLASSES TRADERS',
    'TC1004' => 'INTERNATIONAL MOLASSES TRADERS',
    'TC1005' => 'MUSCOVADO TRADER',
    'TC1006' => 'INTERNATIONAL SUGAR (FRUCTOSE) TRADER',

  ];

?>

<table>

    <thead style="display: table-header-group;">
        
      <tr>
        <td colspan="4" style="text-align: center;">LISTING OF REGISTERED {{ $cat[$request->bdc_tc] }}</td>
      </tr>
        
      <tr>
        <td colspan="4" style="text-align: center;">
          As of {{ __dataType::date_scope($request->bdc_df, $request->bdc_dt) }}
        </td>
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

        <tr>
            <td colspan="4"></td>
        </tr>

        @foreach($trader_registrations as $key => $tr_data)
          <tr>
            <td style="width:3px; text-align: center; vertical-align: top; padding-top:20px;">
                {{ $key + 1 }}
            </td>
            <td style="width:45px; padding-top:20px;">
              {{ optional($tr_data->trader)->name }}<br>
              {{ optional($tr_data->trader)->address }}<br>
              {{ $tr_data->trader_officer }}<br>
              {{ $tr_data->trader_email }}<br>
            </td>
            <td style="width:20px; text-align: center; vertical-align: top;">
                {{ optional($tr_data->trader)->tin }}
            </td>
            <td style="width:20px; text-align: center; vertical-align: top;">
                {{ optional($tr_data->trader)->tel_no }}
            </td>
          </tr>
        @endforeach

    </tbody>

</table>