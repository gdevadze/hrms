<button type="button" class="btn btn-soft-secondary waves-effect waves-light mb-3" onclick="exportExcel()">Excel</button>
<table cellspacing="0" border="0">
    <colgroup width="221"></colgroup>
    <colgroup width="210"></colgroup>
    <colgroup width="208"></colgroup>
    <colgroup width="72"></colgroup>
    <colgroup span="3" width="300"></colgroup>
    <colgroup width="200"></colgroup>
    <colgroup width="84"></colgroup>
    <colgroup span="28" width="68"></colgroup>
    <colgroup width="314"></colgroup>
    <tr>
        <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan={{ $month_days+10 }} height="18" align="right" valign=middle><b><font face="Sylfaen" color="#000000">დანართი N2</font></b></td>
    </tr>
    <tr>
        <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan={{ $month_days+10 }} height="18" align="center" valign=middle><b><font face="Sylfaen" color="#000000">&#4321;&#4304;&#4315;&#4323;&#4328;&#4304;&#4317; &#4307;&#4320;&#4317;&#4312;&#4321; &#4304;&#4326;&#4320;&#4312;&#4330;&#4334;&#4309;&#4312;&#4321; &#4324;&#4317;&#4320;&#4315;&#4304;</font></b></td>
    </tr>
    <tr>
        <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=3 height="18" align="center" valign=bottom><b><font face="Sylfaen" color="#000000">&#4317;&#4320;&#4306;&#4304;&#4316;&#4312;&#4310;&#4304;&#4330;&#4312;&#4312;&#4321; &#4307;&#4304;&#4321;&#4304;&#4334;&#4308;&#4314;&#4308;&#4305;&#4304;</font></b></td>
        <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan={{ $month_days + 7 }} align="left" valign=middle><b><font face="Sylfaen" color="#000000"> {{ $company->title }}</font></b></td>
    </tr>
    <tr>
        <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=3 height="20" align="center" valign=middle><b><font face="Sylfaen" color="#000000">&#4321;&#4304;&#4312;&#4307;&#4308;&#4316;&#4322;&#4312;&#4324;&#4312;&#4313;&#4304;&#4330;&#4312;&#4317; &#4313;&#4317;&#4307;&#4312;</font></b></td>
        <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan={{ $month_days + 7 }} align="left" valign=middle sdval="445561990" sdnum="1033;"><b><font face="Sylfaen" color="#000000">{{ $company->identification_code }}</font></b></td>
    </tr>
    <tr>
        <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=3 height="18" align="center" valign=bottom><b><font face="Sylfaen" color="#000000">&#4321;&#4322;&#4320;&#4323;&#4325;&#4322;&#4323;&#4320;&#4323;&#4314;&#4312; &#4308;&#4320;&#4311;&#4308;&#4323;&#4314;&#4312;</font></b></td>
        <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan={{ $month_days + 7 }} align="left" valign=middle><b><font face="Sylfaen" color="#000000">{{ $users->unique('data.position_name')->implode('data.position_name',', ') }}</font></b></td>
    </tr>
    <tr>
        <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=3 height="21" align="center" valign=middle><b><font face="Sylfaen" color="#000000">&#4328;&#4308;&#4307;&#4306;&#4308;&#4316;&#4312; &#4311;&#4304;&#4320;&#4312;&#4326;&#4312;</font></b></td>
        <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 align="center" valign=middle><b><font face="Sylfaen" color="#000000">{{ $date }}</font></b></td>
        <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan={{ $month_days + 5 }} rowspan=2 align="center" valign=middle><b><font face="Sylfaen" color="#000000">01-დან-{{ $month_days }}-მდე</font></b></td>
    </tr>
    <tr>
        <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=3 height="21" align="center" valign=middle><b><font face="Sylfaen" color="#000000">&#4321;&#4304;&#4304;&#4316;&#4306;&#4304;&#4320;&#4312;&#4328;&#4317; &#4318;&#4308;&#4320;&#4312;&#4317;&#4307;&#4312;</font></b></td>
        <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle><b><font face="Sylfaen" color="#000000">01-დან</font></b></td>
        <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle><b><font face="Sylfaen" color="#000000">{{ $month_days }}-მდე</font></b></td>
    </tr>
    <tr>
        <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan={{ $month_days+10 }} rowspan=2 height="39" align="center" valign=middle><b><font face="Sylfaen" color="#000000"><br></font></b></td>
    </tr>
    <tr>
    </tr>
    <tr>
        <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" rowspan=5 height="110" align="center" valign=middle><b><font face="Sylfaen" color="#000000">&#4306;&#4309;&#4304;&#4320;&#4312;, &#4321;&#4304;&#4334;&#4308;&#4314;&#4312;</font></b></td>
        <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" rowspan=5 align="center" valign=middle><b><font face="Sylfaen" color="#000000">&#4318;&#4312;&#4320;&#4304;&#4307;&#4312; &#4316;&#4317;&#4315;&#4308;&#4320;&#4312;/&#4322;&#4304;&#4305;&#4308;&#4314;&#4312;&#4321; &#4316;&#4317;&#4315;&#4308;&#4320;&#4312;</font></b></td>
        <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" rowspan=5 align="center" valign=middle><b><font face="Sylfaen" color="#000000">&#4311;&#4304;&#4316;&#4304;&#4315;&#4307;&#4308;&#4305;&#4317;&#4305;&#4304; (&#4321;&#4318;&#4308;&#4330;&#4312;&#4304;&#4314;&#4317;&#4305;&#4304;, &#4318;&#4320;&#4317;&#4324;&#4308;&#4321;&#4312;&#4304;)</font></b></td>
        <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan={{ $month_days +1 }} align="center" valign=middle><b><font face="Sylfaen" color="#000000">აღნიშვნები სამუშაოზე გამოცხადების/არგამოცხადების შესახებ თარიღების მიხედვით თვის განმავლობაში</font></b></td>
        <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=5 align="center" valign=middle><b><font face="Sylfaen" color="#000000">&#4321;&#4323;&#4314; &#4316;&#4304;&#4315;&#4323;&#4328;&#4308;&#4309;&#4304;&#4320;&#4312; &#4311;&#4309;&#4312;&#4321; &#4306;&#4304;&#4316;&#4315;&#4304;&#4309;&#4314;&#4317;&#4305;&#4304;&#4328;&#4312;</font></b></td>
    </tr>
    <tr>
        @for($i = 1; $i <= $month_days; $i++)
            <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" rowspan=4 align="center" valign=middle sdval="1" sdnum="1033;"><b>{{ $i }}</b></td>
        @endfor
        <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" rowspan=4 align="center" valign=middle><b><font face="Sylfaen" color="#000000">&#4307;&#4326;&#4308;</font></b></td>
        <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=5 align="center" valign=middle><b><font face="Sylfaen" color="#000000">&#4321;&#4304;&#4304;&#4311;&#4312;</font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
    </tr>
    <tr>
        <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" rowspan=3 align="center" valign=middle><b><font face="Sylfaen" color="#000000">&#4335;&#4304;&#4315;&#4312;</font></b></td>
        <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=4 align="center" valign=middle><b><font face="Sylfaen" color="#000000">&#4315;&#4304;&#4311; &#4328;&#4317;&#4320;&#4312;&#4321;</font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
    </tr>
    <tr>
        <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" rowspan=2 align="center" valign=middle><b><font face="Sylfaen" color="#000000">&#4310;&#4308;&#4306;&#4304;&#4316;&#4304;&#4313;&#4309;&#4308;-&#4311;&#4323;&#4320;&#4312;</font></b></td>
        <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" rowspan=2 align="center" valign=middle><b><font face="Sylfaen" color="#000000">&#4326;&#4304;&#4315;&#4308;</font></b></td>
        <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" rowspan=2 align="center" valign=middle><b><font face="Sylfaen" color="#000000">&#4307;&#4304;&#4321;&#4309;&#4308;&#4316;&#4308;&#4305;&#4312;&#4321;, &#4323;&#4325;&#4315;&#4308; &#4307;&#4326;&#4308;&#4308;&#4305;&#4312;</font></b></td>
        <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" rowspan=2 align="center" valign=middle><b><font face="Sylfaen" color="#000000">&#4321;&#4334;&#4309;&#4304; (&#4321;&#4304;&#4333;&#4312;&#4320;&#4317;&#4308;&#4305;&#4312;&#4321; &#4328;&#4308;&#4315;&#4311;&#4334;&#4309;&#4308;&#4309;&#4304;&#4328;&#4312;)</font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
    </tr>
    <tr>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
    </tr>
    <tr>
        <td style="border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="18" align="center" valign=middle sdval="1" sdnum="1033;"><b><font face="Sylfaen" color="#000000">1</font></b></td>
        <td style="border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle sdval="2" sdnum="1033;"><b><font face="Sylfaen" color="#000000">2</font></b></td>
        <td style="border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle sdval="3" sdnum="1033;"><b><font face="Sylfaen" color="#000000">3</font></b></td>
        <td style="border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan={{ $month_days+1  }} align="center" valign=middle><b><font face="Sylfaen" color="#000000">                                                                                                                                                                                                         4                                                                                                                                                                                                                                                                                                                                                                                           5</font></b></td>
        <td style="border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle sdval="6" sdnum="1033;"><b><font face="Sylfaen" color="#000000">6</font></b></td>
        <td style="border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle sdval="7" sdnum="1033;"><b><font face="Sylfaen" color="#000000">7</font></b></td>
        <td style="border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle sdval="8" sdnum="1033;"><b><font face="Sylfaen" color="#000000">8</font></b></td>
        <td style="border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle sdval="9" sdnum="1033;"><b><font face="Sylfaen" color="#000000">9</font></b></td>
        <td style="border-top: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle sdval="10" sdnum="1033;"><b><font face="Sylfaen" color="#000000">10</font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
    </tr>
    @foreach($users as $user)
        <tr>
            <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="156" align="left" valign=middle bgcolor="#FFFFFF"><b><font face="Sylfaen" color="#000000">{{ $user['data']['full_name'] }}</font></b></td>
            <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle sdval="43936939860" sdnum="1033;"><b><font face="Times New Roman" color="#000000">{{ $user['data']['personal_num'] }}</font></b></td>
            <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle><b><font color="#000000">{{ $user['data']['position_title'] }}</font></b></td>
            @php
                $totalWorkedHours = 0;
                $totalWorkedDays = 0;
                $totalHolidays = 0;
                $others = 0;
                $atNight = 0;
            @endphp
            @foreach($user['result'] as $res)
                <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle sdval="8" sdnum="1033;"><b>
                        <font face="Sylfaen" color="#000000">
                            @isset($res['value'])
                                @if($res['value'] == '')
                                    {{ $res['worked_hours'] }}
                                @elseif($res['status'] != 0)

                                @else
                                    {{ $res['value'] }}
                                @endif
                                @php
                                if($res['value'] == 'ა/შ'){
                                    $others+=1;
                                }
                                if(isset($res['value']) && ($res['value'] == 'დ' || $res['value'] == 'X')){
                                    $totalHolidays += 1;
                                }
                                if(isset($res['at_night']) && ($res['at_night'])){
                                    $atNight += $res['at_night'];
                                }
                                @endphp
                            @endisset
                        </font>
                    </b></td>
            @endforeach
            <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle sdval="19" sdnum="1033;"><b><font face="Sylfaen" color="#000000">{{ $user['data']['must_working_days'] }}</font></b></td>
            <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle sdval="152" sdnum="1033;"><b><font face="Sylfaen" color="#000000">{{ $user['data']['summary_worked_hours'] - $atNight }}</font></b></td>
            <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle><b><font face="Sylfaen" color="#000000"><br></font></b></td>
            <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle><b><font face="Sylfaen" color="#000000"></font>{{ ($atNight > 0) ? $atNight : '' }}</b></td>
            <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle sdval="9" sdnum="1033;"><b><font face="Sylfaen" color="#000000">{{ $totalHolidays }}</font></b></td>
            <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle><b><font face="Sylfaen" color="#000000">{{ $others }}</font></b></td>
            <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        </tr>
    @endforeach

    <tr>
        <td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=3 rowspan=2 height="62" align="center" valign=middle><b><font face="Sylfaen" color="#000000">ორგანიზაციის/სტრუქტურული ქვედანაყოფის ხელმძღვანელი</font></b></td>
        <td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=4 align="center" valign=middle><b><font face="Sylfaen" color="#000000">გოქბერქ თამაჩ</font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td style="border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 align="center" valign=middle><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
    </tr>
    <tr>
        <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=4 align="center" valign=middle><b><font face="Sylfaen" color="#000000">&#4306;&#4309;&#4304;&#4320;&#4312;, &#4321;&#4304;&#4334;&#4308;&#4314;&#4312;</font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 align="center" valign=middle><b><font face="Sylfaen" color="#000000">ხელმოწერა</font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
    </tr>
    <tr>
        <td style="border-left: 1px solid #000000" height="18" align="center" valign=middle><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="center" valign=middle><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="center" valign=middle><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="center" valign=middle><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="center" valign=middle><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="center" valign=middle><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="center" valign=middle><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="center" valign=middle><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="center" valign=middle><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
    </tr>
    <tr>
        <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=3 rowspan=2 height="37" align="center" valign=middle><b><font face="Sylfaen" color="#000000">&#4322;&#4304;&#4305;&#4308;&#4314;&#4312;&#4321; &#4328;&#4308;&#4307;&#4308;&#4306;&#4316;&#4304;&#4310;&#4308; &#4318;&#4304;&#4321;&#4323;&#4334;&#4312;&#4321;&#4315;&#4306;&#4308;&#4305;&#4308;&#4314;&#4312; &#4318;&#4312;&#4320;&#4312;</font></b></td>
        <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=4 align="center" valign=middle><b><font face="Sylfaen" color="#000000">ია იაკობაძე</font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 align="center" valign=middle><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
    </tr>
    <tr>
        <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=4 align="center" valign=middle><b><font face="Sylfaen" color="#000000">გვარი, სახელი</font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 align="center" valign=middle><b><font face="Sylfaen" color="#000000">ხელმოწერა</font></b></td>
        <td align="center" valign=middle><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="right" valign=middle><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
    </tr>
    <tr>
        <td height="18" align="center" valign=middle><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="center" valign=middle><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="center" valign=middle><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="center" valign=middle><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="center" valign=middle><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="center" valign=middle><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=middle><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="center" valign=middle><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="center" valign=middle><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="center" valign=middle><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="center" valign=middle><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="center" valign=middle><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=middle><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="center" valign=middle><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=middle><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="center" valign=middle><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=middle><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=middle><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
    </tr>
    <tr>
        <td height="18" align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
    </tr>
    <tr>
        <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=3 height="18" align="center" valign=bottom><b><font face="Sylfaen" color="#000000">პირობითი აღნიშვნები</font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"> </font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
    </tr>
    <tr>
        <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="37" align="center" valign=middle><b><font face="Sylfaen" color="#000000">X</font></b></td>
        <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle><b><font face="Sylfaen" color="#000000">დასვენების და უქმე დღეები</font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
    </tr>
    <tr>
        <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="37" align="center" valign=middle><b><font face="Sylfaen" color="#000000">&#4328;</font></b></td>
        <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle><b><font face="Sylfaen" color="#000000">შვებულება ანაზღაურებადი</font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
    </tr>
    <tr>
        <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="37" align="center" valign=middle><b><font face="Sylfaen" color="#000000">&#4323;/&#4328;</font></b></td>
        <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle><b><font face="Sylfaen" color="#000000">ანაზღაურების გარეშე შვებულება</font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
    </tr>
    <tr>
        <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="18" align="center" valign=middle><b><font face="Sylfaen" color="#000000">&#4321;/&#4324;</font></b></td>
        <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle><b><font face="Sylfaen" color="#000000">საავადმყოფო ფურცელი</font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
    </tr>
    <tr>
        <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="37" align="center" valign=middle><b><font face="Sylfaen" color="#000000">&#4307;/&#4328;</font></b></td>
        <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle><b><font face="Sylfaen" color="#000000">დეკრეტული შვებულება (ანაზღაურებადი)</font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
    </tr>
    <tr>
        <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="18" align="center" valign=middle><b><font face="Sylfaen" color="#000000">&#4307;</font></b></td>
        <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle><b><font face="Sylfaen" color="#000000">დასვენება, უქმე დღე</font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
    </tr>
    <tr>
        <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" height="28" align="center" valign=middle><b><font face="Sylfaen" color="#000000">&#4306;</font></b></td>
        <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" align="center" valign=middle><b><font face="Sylfaen" color="#000000">გაცდენა</font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
        <td align="left" valign=bottom><b><font face="Sylfaen" color="#000000"><br></font></b></td>
    </tr>
</table>
