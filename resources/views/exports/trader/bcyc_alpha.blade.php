
<table>

    <thead style="display: table-header-group;">
        
      <tr>
        <td colspan="4" style="text-align: center;">LISTING OF REGISTERED DOMESTIC SUGAR TRADERS</td>
      </tr>
        
      <tr>
        <td colspan="4" style="text-align: center;">CROP YEAR {{ $crop_year->name }}</td>
      </tr>
        
      <tr>
        <td colspan="4">&nbsp;</td>
      </tr>

      <tr>
        <th style="text-align: center; font-weight: bold;">#</th>
        <th style="font-weight: bold;">NAME &amp; ADDRESS</th>
        <th style="text-align: center; font-weight: bold;">TIN</th>
        <th style="text-align: center; font-weight: bold;">TEL. NO. / FAX NO.</th>
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