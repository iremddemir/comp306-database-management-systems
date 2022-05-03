<?php


function check_cid($cid){
    return is_numeric($cid);
}

function check_name($name){
    return ctype_alpha($name) and (strlen($name) < 35);
}

function check_country_code($conn,$country_code){
    return is_contains($conn,$country_code, "CountryCode", "city") and ctype_alpha($country_code) and (strlen($str) < 3);
}

function check_district($district){
    return ctype_alpha($district) and (strlen($district) < 20);
}

function check_population($population){
    return is_numeric($population);
}

function check_country($conn, $country){
    ########
    #Please enter your code here
    $is_contains = is_contains($conn,$country, "Name", "country");
    ########
    return $is_contains;
}

function get_city_info($conn,$cid){

    if ($result = mysqli_query($conn, "SELECT * FROM city WHERE ID=" . $cid )) {
        return $result;
    }
}

function is_contains($conn,$string, $needle, $table_name){
    $is_contains = False;

    ########
    #Please enter your code here
    #query var to story wanted query
    $query = "SELECT * FROM " .$table_name. " WHERE " .$needle. " ='" .$string. "'" ;
    if($result = mysqli_query($conn, $query)){
        if(mysqli_num_rows($result) > 0){
            $is_contains = True;
        }
        
    }
    ########
    return $is_contains;
}

function diff_lang($conn, $country1, $country2){

    $result = Null;
    ########
    #Please enter your code here
    $query = "SELECT cl1.Language from countrylanguage cl1, country c1 where c1.name = '" .$country1. "' and c1.code = cl1.countrycode and cl1.Language not in (select cl2.Language from countrylanguage cl2, country c2 where c2.name = '" .$country2. "' and c2.code = cl2.countrycode)";
    if($result = mysqli_query($conn, $query)){
        return $result;
    }
    ########
    #return $result;
}

function diff_lang_join($conn, $country1, $country2){

    $result = Null;
    ########
    #Please enter your code here

    ########
    $query = "select cl1.Language from countrylanguage cl1 inner join country c1 on c1.code = cl1.countrycode cross join country c2 left outer join countrylanguage cl2 on cl1.Language = cl2.Language and cl2.countrycode = c2.code where c1.name = '" .$country1. "' and c2.name = '" .$country2. "' and cl2.language  is NULL order by cl1.language";
    
    if($result = mysqli_query($conn, $query)){
        return $result;
    }
    return $result;
}

function aggregate_countries($conn,$agg_type, $country_name){

    $result = Null;
    ########
    #Please enter your code here
    $query = "select Name, LifeExpectancy, GovernmentForm, Language from country join countrylanguage on country.code = countrylanguage.countrycode where LifeExpectancy > (select " .$agg_type. "(LifeExpectancy) from country) and LifeExpectancy < ( select LifeExpectancy from country where name = '" .$country_name. "')  and  IsOfficial = 'T'";
    echo($query);
    if($result = mysqli_query($conn, $query)){
        return $result;
    }
    ########
    return $result;
}



function print_table($table_name, $result){

    if ($table_name === 'city'){

        ?><br>

        <table border='1'>

        <tr>

        <th>ID</th>

        <th>Name</th>

        <th>Country Code</th>

        <th>District</th>

        <th>Population</th>

        </tr>

        <?php


        foreach($result as $row){

            echo "<tr>";

            echo "<td>" . $row['ID'] . "</td>";

            echo "<td>" . $row['Name'] . "</td>";

            echo "<td>" . $row['CountryCode'] . "</td>";

            echo "<td>" . $row['District'] . "</td>";

            echo "<td>" . $row['Population'] . "</td>";

            echo "</tr>";
        }

        echo "</table>";
    }
    if ($table_name === 'language'){
        
        ?><br>

        <table border='1'>

        <tr>

        <th>Language</th>

        </tr>

        <?php


        foreach($result as $row){

            echo "<tr>";

            echo "<td>" . $row['Language'] . "</td>";

            echo "</tr>";
        }

        echo "</table>";
        
    }
    if ($table_name === 'aggregate'){

                ?><br>

                <table border='1'>

                <tr>

                <th>Name</th>

                <th>LifeExpectancy</th>

                <th>GovernmentForm</th>

                <th>Language</th>

                </tr>

                <?php


                foreach($result as $row){

                    echo "<tr>";

                    echo "<td>" . $row['Name'] . "</td>";

                    echo "<td>" . $row['LifeExpectancy'] . "</td>";

                    echo "<td>" . $row['GovernmentForm'] . "</td>";

                    echo "<td>" . $row['Language'] . "</td>";

                    echo "</tr>";
                }

                echo "</table>";
            }
           //for debugging purposes
            if ($table_name === 'question5'){
                     ?><br>
                        <table border='1'>
                        <tr>
                        <th>COL1</th>
                        <th>COL2</th>
                        <th>COL3</th>
                        </tr>
                        <?php
                            foreach($result as $row){
                                    echo "<tr>";
                                #change column names for parts
                                    echo "<td>" . $row['Name'] . "</td>";
                                    echo "<td>" . $row['Continent'] . "</td>";
                                    echo "<td>" . $row['LifeExpectancy'] . "</td>";
                                    echo "</tr>";
                                }
                                echo "</table>";
                            }
                          

            

}

function insert_city($conn,$cid, $name, $country_code, $district, $population){


    $sql = "INSERT INTO city(ID, Name, CountryCode, District, Population) VALUES('$cid', '$name', '$country_code', '$district','$population');";
    if ($conn->query($sql) === TRUE) { #We used different function to run our query.
        echo "<br>Record updated successfully<br>";
    } else {
        echo "<br>Error updating record: " . $conn->error . "<br>";
    }
}

function remove_city($conn,$cid){
    $sql = "DELETE FROM city WHERE ID='$cid'";
    if ($conn->query($sql) === TRUE) {
        echo "Record updated successfully";
    } else {
        echo "Error updating record: " . $conn->error;
    }

}

function manipulate_city($conn,$cid,$name){

    $sql = "UPDATE city SET Name='$name' WHERE ID='$cid'" ;
    if ($conn->query($sql) === TRUE) {
        echo "Record updated successfully";
    } else {
        echo "Error updating record: " . $conn->error;
    }

}
 
### QUESTION 5 FUNCTIONS
#part-a
function find_min_max_continent($conn){
    $result = Null;
    $query = "select c.Name, c.Continent, c.LifeExpectancy from country c join (select Continent, min(LifeExpectancy) as min_lifeexpectancy, max(LifeExpectancy) as max_lifeexpectancy from country group by continent) s on (c.LifeExpectancy = s.min_LifeExpectancy or s.max_LifeExpectancy =  c.LifeExpectancy) AND s.continent = c.continent";
    
    if($result = mysqli_query($conn, $query)){
        #for debugging purposes
        #uncomment if you want to see the results in results_quiz page on GUI, do not forget to change print_table with correct column names
        #print_table('question5', $result);
        return $result;
    }
    return $result;
}
#part-b
function find_country_language($conn, $percentage, $language){
    $result = Null;
    $query = "select c.Name,cl.Language, cl.Percentage from country c join countrylanguage cl on c.code = cl.countrycode where cl.language = '" .$language. "' and cl.percentage > " .$percentage;
    
    if($result = mysqli_query($conn, $query)){
        #for debugging purposes
        #uncomment if you want to see the results in results_quiz page on GUI, do not forget to change print_table with correct column names
        #print_table('question5', $result);
        return $result;
    }

    return $result;
}
#part-c
function find_country_count($conn, $amount){
    $result = Null;
    $query = "select c.Name, c.LifeExpectancy, c.Continent from country c join (select   Continent, max(LifeExpectancy) as max_LifeExpectancy from (select country.* from country join  city on country.code = city.countrycode group by city.countrycode having count(*) > " .$amount.") as city_filtered group by continent) s on (s.max_LifeExpectancy =  c.LifeExpectancy) AND s.continent = c.continent";
    if($result = mysqli_query($conn, $query)){
        #for debugging purposes
        #uncomment if you want to see the results in results_quiz page on GUI, do not forget to change print_table with correct column names
        #print_table('question5', $result);
        return $result;
    }
    
    return $result;
}

