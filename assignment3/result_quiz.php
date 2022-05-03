<?php

require_once 'include/dbConnect.php';
require_once 'include/functions_quiz.php';
    
#echo is_contains($conn, "AFK", "countryCode", "city");
#echo  is_contains($conn, "AFG", "countryCode", "city");
#find_country_language($conn, 85, "Turkish");
#find_min_max_continent($conn);
#find_country_count($conn, 100);
if (isset($_POST['insert'])){

    $cid = $_POST["cid_insert"];
    $name = $_POST["name_insert"];
    $country_code = $_POST["country_code_insert"];
    $district = $_POST["district_insert"];
    $population = $_POST["population_insert"];

    if(check_cid($cid) !== true){
        exit("Wrong cid value");
    }

    if(check_name($name) !== true){
        exit("Wrong name");
    }

    if(check_country_code($conn,$country_code) !== true){
        exit("Wrong country code");
    }

    if(check_district($district) !== true){
        exit("Wrong district");
    }

    if(check_population($population) !== true){
        exit("Wrong population");
    }

    $result = get_city_info($conn,$cid);
    echo "Returned rows are: " . mysqli_num_rows($result);
    print_table('city', $result);
    mysqli_free_result($result);
    insert_city($conn,$cid, $name, $country_code, $district, $population);
    $result = get_city_info($conn,$cid);
    echo "Returned rows are: " . mysqli_num_rows($result);
    print_table('city', $result);
    mysqli_free_result($result);
}


if (isset($_POST['remove'])){

    $cid = $_POST["cid_remove"];

    if(check_cid($cid) !== true){
        exit("Wrong cid value");
    }
    $result = get_city_info($conn,$cid);
    echo "Returned rows are: " . mysqli_num_rows($result);
    print_table('city', $result);
    mysqli_free_result($result);
    remove_city($conn,$cid);
    $result = get_city_info($conn,$cid);
    echo "Returned rows are: " . mysqli_num_rows($result);
    print_table('city', $result);
    mysqli_free_result($result);
}


if (isset($_POST['manipulate'])){

    $cid = $_POST["cid_manipulate"];
    $name = $_POST["name_insert"];

    if(check_cid($cid) !== true){
        exit("Wrong cid value");
    }
    get_city_info($conn,$cid);
    manipulate_city($conn,$cid,$name);
    get_city_info($conn,$cid);
}

if (isset($_POST['difference'])){

    $first_country = $_POST["first_country"];
    $second_country = $_POST["second_country"];

    if(check_country($conn,$first_country) !== true){
        exit("Wrong country name");
    }
    if(check_country($conn,$second_country) !== true){
        exit("Wrong country name");
    }
      $result =  diff_lang($conn, $first_country, $second_country);
      print_table('language', $result);
      mysqli_free_result($result);
    }

if (isset($_POST['difference_join'])){

    $first_country = $_POST["first_country"];
    $second_country = $_POST["second_country"];
    
    if(check_country($conn,$first_country) !== true){
        exit("Wrong country name");
    }
    if(check_country($conn,$second_country) !== true){
        exit("Wrong country name");
        }
        $result =  diff_lang_join($conn, $first_country, $second_country);
        print_table('language', $result);
        mysqli_free_result($result);
        }


if (isset($_POST['life_expectancy'])){

        $agg = $_POST["aggregation"];
        $name = $_POST["name"];
        
        if(check_country($conn,$name) !== true){
            exit("Wrong country name");
        }
            $result =  aggregate_countries($conn, $agg, $name);
            print_table('aggregate', $result);
            mysqli_free_result($result);
            }


