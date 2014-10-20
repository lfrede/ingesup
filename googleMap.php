<html>
    <script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
    <script type="text/javascript">
        window.onload = function(){
          var config = {
              latitude  : 43.854084,
              longitude : -0.074147
          };
   
          // Création d'un objet pLatLng pour stocker les coordonnées
          var latlng = new google.maps.LatLng(config.latitude, config.longitude);
   
          // Options de la carte
          var myOptions = {
              zoom: 14,
              center: latlng,
              // mapTypeId: google.maps.MapTypeId.SATELLITE
              mapTypeId: google.maps.MapTypeId.HYBRID
          };
   
          // Création et affichage de la carte dans le div map_canvas
          var map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
   
          // Ajout d'un marqueur sur la carte
          var mark = new google.maps.Marker({
              position: latlng,
              map:      map,
              title:    config.location
          });
      }
    </script>
</html>