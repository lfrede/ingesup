<html>
  <head>
    <meta charset="utf-8"/>
      <?php
        try
        {
          $bdd=new PDO("mysql:host=localhost;dbname=eventz","root","", array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
        }
        catch(Exception $e)
        {
          die("Erreur: ".$e->getMessage());
        }

        session_start();
      ?>
  </head>
  <body>

    <?php

      //$_SESSION["id"]=1;
  
      $urlWebServiceGoogle = 'http://maps.google.com/maps/api/geocode/json?address=%s&sensor=false&language=fr';
        
      $req = "SELECT spiedCity FROM users Where id=1";
      $req = $bdd->prepare("SELECT spiedCity FROM users Where id=".$_SESSION["id"]);
      $reponse = $req->execute(array());
      $donnees = $req->fetch();
          
  
      $adresse = mysql_real_escape_string(htmlspecialchars($donnees[0]));
      $url = vsprintf($urlWebServiceGoogle, urlencode($adresse));
      $response = json_decode(file_get_contents($url));
      
      if (empty($response->status)) throw new Exception();
      if($response->status != "OK") throw new Exception($response->status);
      $latitude =  $response->results[0]->geometry->location->lat;
      $longitude = $response->results[0]->geometry->location->lng;
  
  
        
      $req = "SELECT latitude, longitude FROM event";
      $res = $bdd->query($req);
      $postalAddress=array();
      $ligne = $res->fetchAll(PDO::FETCH_ASSOC);
      foreach ($ligne as $resultat) 
      {
        $postalAddress[] = $resultat;
      }

    ?>

    <script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
    <script type="text/javascript">
      window.onload = function(){
        var lecentre = new google.maps.LatLng(<?php echo $latitude; ?>, <?php echo $longitude; ?>);

        // Options de la carte
        var myOptions = {
          zoom: 13,
          center: lecentre,
          // mapTypeId: google.maps.MapTypeId.SATELLITE
          mapTypeId: google.maps.MapTypeId.HYBRID
        };
   
        // Création et affichage de la carte dans le div map_canvas
        var map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
    
        <?php
          foreach ($postalAddress as $key => $value) {
            $latitude = $value["latitude"];
            $longitude = $value["longitude"];
        ?>  

        var config = {
          latitude  : <?php echo $latitude?>,
          longitude : <?php echo $longitude ?>
        };

        // Création d'un objet pLatLng pour stocker les coordonnées
        var latlng = new google.maps.LatLng(config.latitude, config.longitude);
    
        var marqueur = new google.maps.Marker({
          position:latlng,
          map: map
        });

        <?php 
          } 
        ?>
      }

    </script>

    <div id="map_canvas" style="width:980px; height:460px;"> </div>
  </body>
</html>
