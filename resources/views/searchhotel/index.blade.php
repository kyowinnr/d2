<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Continent and Countries</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        .continent-group {
            margin-bottom: 20px;
        }

        .continent-group h3 {
            font-weight: bold;
            color: #333;
        }

        .continent-group ul {
            margin-left: 20px;
        }

        .continent-group ul li {
            font-size: 14px;
            color: #555;
        }
    </style>
   
</head>
<body>
  <table>
   <tr>
     <th>亞洲</th>
     <th>歐洲</th>
     <th>美洲</th>
     <th>大洋洲</th>
     <th>未分類</th>
   </tr>
   <tr>
    <td>
      <table>
        @foreach ($type1 as $countries)
        <tr>
          <td><a href="{{ route('search-continent', ['ContinentID' => $countries->ContinentID]) }}">{{ $countries->Country }}</a></td>          
        </tr>
        @endforeach
      </table>
    </td>
    <td style=" vertical-align: top;">
      <table>
        @foreach ($type2 as $countries)
        <tr>
          <td><a href="{{ route('search-continent', ['ContinentID' => $countries->ContinentID]) }}">{{ $countries->Country }}</a></td>
        </tr>
        @endforeach
      </table>
    </td> 
    <td style=" vertical-align: top;">
      <table>
        @foreach ($type3 as $countries)
        <tr>
          <td><a href="{{ route('search-continent', ['ContinentID' => $countries->ContinentID]) }}">{{ $countries->Country }}</a></td>
        </tr>
        @endforeach
      </table>
    </td>
    <td style=" vertical-align: top;">
      <table>
        @foreach ($type4 as $countries)
        <tr>
          <td><a href="{{ route('search-continent', ['ContinentID' => $countries->ContinentID]) }}">{{ $countries->Country }}</a></td>
        </tr>
        @endforeach
      </table>
    </td> 
    <td>
      <table style=" vertical-align: top;">
        @foreach ($type5 as $countries)
        <tr>
          <td><a href="{{ route('search-continent', ['ContinentID' => $countries->ContinentID]) }}">{{ $countries->Country }}</a></td>
        </tr>
        @endforeach
      </table>
    </td>     
   </tr>
  </table>
  <table border="1" cellspacing="0"  class="table table-bordered table-striped">
   @foreach ($hotels->chunk(6) as $hotelGroup)
        <tr>
            @foreach ($hotelGroup as $hotel)
                <td>
                    <a href="javascript:void(0)" 
                       onclick="selectHotel('{{ $hotel->HotelName }}', '{{ $hotel->HotelId }}')">
                       {{ $hotel->HotelName }}
                    </a>
                </td>
            @endforeach
        </tr>
    @endforeach
  </table>  
    <script>
    function selectHotel(hotelName, hotelId) {
        // 使用 window.opener 更新父頁面的隱藏欄位和文字框
        window.opener.document.getElementById('HotelName').value = hotelName;
        window.opener.document.getElementById('HotelId').value = hotelId;

        // 關閉當前頁面
        window.close();
    }
</script>

</body>
</html>

