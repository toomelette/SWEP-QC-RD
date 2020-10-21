<table class="table table-bordered">

        <thead>
        
          <tr>
            <td colspan="4">Mill District Library</td>
          </tr>
            
          <tr>
            <td colspan="4">CROP YEAR {{ $crop_year->name }}</td>
          </tr>
            
          <tr>
            <td colspan="4">&nbsp;</td>
          </tr>

          <tr>
            <th rowspan="2" style="width:50px;">Mills</th>
            
            @if (in_array('1', $fields))
              <th colspan="1" rowspan="2" style="width:15px;">Mill License</th>
            @endif
            
            @if (in_array('2', $fields))
              <th colspan="1" rowspan="2" style="width:15px;">Refinery License</th>
            @endif
            
            @if (in_array('3', $fields))
              <th colspan="2"  style="text-align: center; width:15px;">Mill Participation</th>
            @endif
            
            @if (in_array('4', $fields))
              <th colspan="1" rowspan="2" style="width:15px;">Mill Rated Capacity</th>
            @endif
            
            @if (in_array('5', $fields))
              <th colspan="1" rowspan="2" style="width:15px;">Refinery Rated Capacity</th>
            @endif
            
            @if (in_array('6', $fields))
              <th colspan="1" rowspan="2" style="width:15px;">Molasses Tank 1</th>
            @endif
            
            @if (in_array('7', $fields))
              <th colspan="1" rowspan="2" style="width:15px;">Molasses Tank 2</th>
            @endif
            
            @if (in_array('13', $fields))
              <th colspan="1" rowspan="2" style="width:15px;">Molasses Tank 3</th>
            @endif
            
            @if (in_array('8', $fields))
              <th colspan="1" rowspan="2" style="width:15px;">Est. Start of Milling</th>
            @endif
            
            @if (in_array('9', $fields))
              <th colspan="1" rowspan="2" style="width:15px;">Est. End of Milling</th>
            @endif
            
            @if (in_array('10', $fields))
              <th colspan="3" style="text-align: center; width:15px;">Crop Estimates</th>
            @endif
            
            @if (in_array('11', $fields))
              <th colspan="2" style="text-align: center; width:15px;">Area Harvested</th>
            @endif
            
            @if (in_array('12', $fields))
              <th colspan="2" style="text-align: center; width:15px;">Area Planted</th>
            @endif
            
          </tr>

          <tr>
            @if (in_array('3', $fields))
              <th>Planter</th>
              <th>Miller</th>
            @endif
            @if (in_array('10', $fields))
              <th>GTCM MT</th>
              <th>RAW MT</th>
              <th>RAW LKG</th>
            @endif
            @if (in_array('11', $fields))
              <th>Plane Cane</th>
              <th>Ratoon Cane</th>
            @endif
            @if (in_array('12', $fields))
              <th>Plane Cane</th>
              <th>Ratoon Cane</th>
            @endif
          </tr>

          <tr>
            
          </tr>
        </thead>

        <tbody>

          @foreach (__static::report_regions() as $rr_name => $rr_key)

            <tr>
              <th style="vertical-align: text-top; padding-top:5px; font-weight:bold;" colspan="18">
                {{ $rr_name }}
              </th>
            </tr>

            @foreach($mill_registrations as $data)
              @if (!empty($data->mill))
                @if ($data->mill->report_region == $rr_key)
                  <tr>

                    <td style="vertical-align: text-top; padding-top:5px;">
                      {{ optional($data->mill)->name }}
                    </td>

                    @if (in_array('1', $fields))
                      <td>{{ $data->license_no}}</td>
                    @endif

                    @if (in_array('2', $fields))
                      <td></td>
                    @endif

                    @if (in_array('3', $fields))
                      <td>{{ number_format($data->planter_share, 2) }}%</td>
                      <td>{{ number_format($data->mill_share, 2) }}%</td>
                    @endif

                    @if (in_array('4', $fields))
                      <td>{{ number_format($data->rated_capacity, 2) }} Tc/day</td>
                    @endif

                    @if (in_array('5', $fields))
                      <td></td>
                    @endif

                    @if (in_array('6', $fields))
                      <td>{{ number_format($data->molasses_tank_first, 2) }} MT</td>
                    @endif

                    @if (in_array('7', $fields))
                      <td>{{ number_format($data->molasses_tank_second, 2) }} MT</td>
                    @endif

                    @if (in_array('13', $fields))
                      <td>{{ number_format($data->molasses_tank_third, 2) }} MT</td>
                    @endif

                    @if (in_array('8', $fields))
                      <td>{{ __dataType::date_parse($data->est_start_milling, 'm/d/Y') }}</td>
                    @endif

                    @if (in_array('9', $fields))
                      <td>{{ __dataType::date_parse($data->est_end_milling, 'm/d/Y') }}</td>
                    @endif

                    @if (in_array('10', $fields))
                      <td>{{ number_format($data->gtcm_mt, 2) }}</td>
                      <td>{{ number_format($data->raw_mt, 2) }}</td>
                      <td>{{ number_format($data->raw_lkg, 2) }}</td>
                    @endif

                    @if (in_array('11', $fields))
                      <td>{{ number_format($data->ah_plant_cane, 2) }}</td>
                      <td>{{ number_format($data->ah_ratoon_cane, 2) }}</td>
                    @endif

                    @if (in_array('12', $fields))
                      <td>{{ number_format($data->ap_plant_cane, 2) }}</td>
                      <td>{{ number_format($data->ap_ratoon_cane, 2) }}</td>
                    @endif
                    
                  </tr>
                @endif
              @endif
            @endforeach
            
          @endforeach

          

        </tbody>

      </table>