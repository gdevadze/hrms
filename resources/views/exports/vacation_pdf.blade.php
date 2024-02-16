<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>შვებულების ფორმა - {{ $vacation->user->personal_num }}</title>
</head>
<body>


<table>

    <thead>
    <tr>
        <th colspan="4"> <center><h1>შვებულების ფორმა</h1></center></th>

        <th scope="col"><center> <h5 style="width: 150px;">შევსების თარიღი</h5></center>
            <br>
            <center>{{ $vacation->formatted_create_date }}</center></th>

    </tr>

    </thead>
    <tfoot>

    </tfoot>
    <tbody>
    <tr>
        <th scope="row" colspan="2">სახელი/გვარი <br><br>
            {{ $vacation->user->full_name }}</th>
        <td colspan="3"> <b>კომპანია	„ASYA SOFTWARE“ A.Ş. 	<br><br>
                პ/ნ {{ $vacation->user->personal_num }}</b>

        </td>


    </tr>
    <tr>
        <th scope="row" rowspan="3" ><h1 style="height: 200px; writing-mode: vertical-lr;
                transform: rotate(180deg);margin-left: 20%;"><center>შვებულების აღწერა</center></th>
        <td>შვებულების დაწყების თარიღი</td>
        <td>შვებულების დასრულების თარიღი</td>
        <td>მუშაობის დაწყების თარიღი</td>
        <td>შვებულების ვადა</td>
    </tr>
    <tr>
        <th scope="row">{{ $vacation->formatted_start_date }}</th>
        <td>{{ $vacation->formatted_end_date }}</td>
        <td>{{ $nextWorkingDay }}</td>
        <td>{{ (int)$vacationDays }} დღე</td>
    </tr>
    <tr>
        <th scope="row"><h5 style="width: 250px; font-size: 18px;"> წლიური</h5> <br> <br><h5 style="width: 250px; font-size: 18px;">საპატიო</h5> </th>
        <td><h5 style="width: 250px;font-size: 18px;">ანაზღაურებადი</h5> <br><h5 style="font-size: 18px;">განმარტება:</h5>  </td>
        <td colspan="2"><h5 style="width: 250px;font-size: 18px;">ანაზღაურების გარეშე </h5> </td>

    </tr>

    <tr>
        <th scope="row"> <br>
        </th>
        <td>    <b><center>
                    დასაქმებული</center></b>
        </td>
        <td><b><center> მენეჯერი</center></b> </td>
        <td colspan="2"><b><center> დირექტორი</center></b></td>

    </tr>

    <tr>
        <th scope="row">სახელი/გვარი
        </th>
        <td>
            <b> <center>{{ $vacation->user->full_name_en }}</center></b>
        </td>
        <td>  </td>
        <td colspan="2"><b><center> GOKBERK TAMAÇ	</center></b>
        </td>

    </tr>

    <tr>
        <th scope="row" rowspan="2" style="height: 120px;">ხელმოწერა:
        </th>
        <td rowspan="2">

        </td>
        <td rowspan="2">  </td>
        <td colspan="2">

        </td>


    </tr>


    </tbody>
</table>

</body>
</html>


<style>*,
    *:before,
    *:after {
        -moz-box-sizing: border-box;
        -webkit-box-sizing: border-box;
        box-sizing: border-box;
    }

    body {
        font-family: "Nunito", sans-serif;
        color: #384047;
    }

    table {
        max-width: 960px;
        margin: 10px auto;
    }

    caption {
        font-size: 1.6em;
        font-weight: 400;
        padding: 10px 0;
    }

    thead th {
        font-weight: 400;
        background: #8a97a0;
        color: #fff;
    }

    tr {
        background: lightblue;
        border-bottom: 1px solid #fff;
        margin-bottom: 5px;
    }

    tr:nth-child(even) {
        background-color:whitesmoke;
    }

    th,
    td {
        text-align: center;
        padding: 25px;
        font-weight: 300;
    }

    tfoot tr {
        background: none;
    }

    tfoot td {
        padding: 10px 2px;
        font-size: 0.8em;
        font-style: italic;
        color: #8a97a0;
    }
</style>

</body>
</html>
