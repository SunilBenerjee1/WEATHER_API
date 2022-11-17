<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <style>
        *{
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        .input{
        height: 44px;
        font-size: 20px;
        text-align: center;
        font-weight: 500;
      }

      .search{
        width: 200px;
        font-size: 20px;
        outline: none;
        box-shadow: none;
      }
    </style>
</head>
<body>

<nav class="navbar bg-light">
  <div class="container-fluid">
    <a class="navbar-brand text-dark" style="font-weight:700" href="./welcome.php">
      Weather App
    </a>
  </div>
</nav>
    <div class="container my-4">
        <p class="h3 text-center mb-4">Weather Info</p>
        <form action="<?php $_SERVER['PHP_SELF']; ?>" method="post">
            <div class="form-group">
                <label for="state" class="h5">Select State :</label>
                <select class="form-control input" name="state" id="state">
                    <option selected disabled>Select</option>
                    <option value="delhi">Delhi</option>
                    <option value="haryana">Haryana</option>
                    <option value="himachal">Himachal Pradesh</option>
                    <option value="jammu">Jammu and Kashmir</option>
                    <option value="andhra">Andhra Pradesh</option>
                    <option value="assam">Assam</option>
                    <option value="chhattisgarh">Chhattisgarh</option>
                    <option value="bihar">Bihar</option>
                    <option value="karnataka">Karnataka</option>
                    <option value="kerala">Kerala</option>
                    <option value="manipur">Manipur</option>
                    <option value="meghalaya">Meghalaya</option>
                    <option value="mizoram">Mizoram</option>
                    <option value="punjab">Punjab</option>
                    <option value="rajasthan">Rajasthan</option>
                </select>
            </div>
            <div class="d-flex justify-content-center">
                <button type="submit" name="search" value="search" class="mt-2 btn btn-dark form-control search">Search</button>
            </div>
        </form>
    </div>
</body>
</html>

<?php
    if(isset($_POST['search']) && $_POST['search'] != null){
        if(isset($_POST['state']) && $_POST['state'] != null){
            $curl = curl_init();
            $state_name = $_POST['state'];
            curl_setopt_array($curl, [
                CURLOPT_URL => "https://weatherapi-com.p.rapidapi.com/current.json?q=".$state_name."",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "GET",
                CURLOPT_HTTPHEADER => [
                    "X-RapidAPI-Host: weatherapi-com.p.rapidapi.com",
                    "X-RapidAPI-Key: d992c994a7msh1985fb26a519566p1b0008jsnba95e7882ec5"
                ],
            ]);
            $response = curl_exec($curl);
            $err = curl_error($curl);
            curl_close($curl);
            if ($err) {
                echo "cURL Error #:" . $err;
            } else {
                $json_data = json_decode($response, true);
                $location = array(); $current = array();
                $location[] = $json_data['location'];
                $current[] = $json_data['current'];
                echo "<div class='card' style='width: 22rem; margin: 20px auto;'>
                        <img src='".$current[0]['condition']['icon']."' class='card-img-top' alt='image'>
                        <div class=''>
                        <div class='card-body' style='margin: 0 0 10px 10px;'>
                            <h5 class='card-title text-center mb-4'><b><i>".$location[0]['region']."</i></b></h5>
                            <div class='ml-4'>
                            <p class='card-text'>
                                Temprature (&#176;C) : <b><i>".$current[0]['temp_c'].
                                "&#176;C</i></b><br>Temprature (&#176;F)&nbsp;:<b><i> ".$current[0]['temp_f'].
                                "&#176;f</i></b><br>Wind Speed &nbsp;&nbsp;&nbsp; &nbsp;: <b><i>".$current[0]['wind_mph'].
                                " mph</i></b><br>Humidity &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: <i><b>".$current[0]['humidity'].
                            " %</b></i></p>
                            </div>
                        </div>
                        </div>
                </div>";
            }
        }
    }
?>