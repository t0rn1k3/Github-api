<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Task#2</title>
</head>
<body>
<div class="task2">
            <h2>TASK #2</h2>
            <form class="search-form" action="index.php" method="get">
            <select name="select">
                <option value="choose" hidden>Choose One Option</option>
                <option name="repos" value="repos">Show Repositories</option>
                <option name="followers" value="followers">Show Folloewrs</option>
            </select>
            <div>
                <input class="search-user" type="text" name="username">
                <input type="submit" class="search-submit" name="submitName" value="Search"> 
            </div>
            </form>
            <div class="info-container">
                <ol class="repository">
                    <?php
                        if (isset($_GET['submitName'])) {
                            $userName = $_GET['username'];
                            

                            
    
                            if (!empty($_GET['username'])) {
    
                                $curl = curl_init();
                                
                                $response = [];

                                $page = 1;
                                $count = 1;
                                
                                while($count == 1){
                                    curl_setopt_array($curl, [
                                        CURLOPT_RETURNTRANSFER => 1,
                                        CURLOPT_URL => "https://api.github.com/users/".$userName."/repos?page={$page}",
                                        CURLOPT_USERAGENT => 'User Repos'
                                    ]);
        
                                    $data = curl_exec($curl);
        
                                    $result = json_decode($data, true);

                                    if (sizeof($result) == 0) {
                                        $count = 0;
                                    }
                                    $page += 1;

                                    array_push($response,...$result);
                                    
                                }

                                if (!empty($_GET['select'])) {
                                    $selected = $_GET['select'];
                                    if ($selected == "repos") {
                                        foreach($response as $resp){
                                            echo '<li><a target="_blank" href="'.$resp["html_url"].'">'.$resp["name"].'</a></li>';
                                        }
                                    }
    
                                }
    
                                
                                curl_close($curl);
                            }

                        }
                    ?>
                </ol>
                <ol class="followers">
                    <?php 
                        if (isset($_GET['submitName'])) {
                            $userName = $_GET['username'];
    
                            if (!empty($_GET['username'])) {

                                
                                $curL = curl_init();

                                $followerResult = [];

                                $followerPage = 1;
                                $followerCount = 1;

                                while ($followerCount == 1) {
                                    curl_setopt_array($curL, [
                                        CURLOPT_RETURNTRANSFER => 1,
                                        CURLOPT_URL => "https://api.github.com/users/".$userName."/followers?page={$followerPage}",
                                        CURLOPT_USERAGENT => 'User Followers'
                                    ]);
        
                                    $datA = curl_exec($curL);
        
                                    $resulT = json_decode($datA, true);

                                    if (sizeof($resulT) == 0) {
                                        $followerCount = 0;
                                    }
                                    $followerPage += 1;

                                    array_push($followerResult,...$resulT);
                                }
    
                                if (!empty($_GET['select'])) {
                                    $selected = $_GET['select'];
                                    if ($selected == "followers") {
                                        foreach($followerResult as $resP){
                                            echo '<li><a target="_blank" href="'.$resP["html_url"].'"><img src="'.$resP["avatar_url"].'"><span>'.$resP["login"].'</span></a></li>';
                                        }
                                        
                                    }
    
                                }

                                curl_close($curL);
                            }

                        }
                    ?> 
                </ol>
            </div>
        </div>
</body>
</html>