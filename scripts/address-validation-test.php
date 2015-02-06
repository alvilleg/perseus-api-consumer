<html>
<head>
  <script>    
    function validateAddress(){      
      var cityEle = document.getElementById("city");      
      var addressEle = document.getElementById("address");      
      var callResultDiv = document.getElementById("call_result");      
      var request = new XMLHttpRequest();      
      request.open('GET',                    
                   'query-address.php?city='+cityEle.value+"&address="+addressEle.value,                    
                   false);      
      request.send();      
      if (request.status === 200) {        
        var latEle = document.getElementById("lat");        
        var lngEle = document.getElementById("lng"); 
        var neighborhoodEle = document.getElementById("neighborhood"); 
               
        var obj = eval( request.responseText);        
        callResultDiv.innerHTML = obj[0].normalizedAddress;        
        if(obj[0].lat){          
          latEle.value = obj[0].lat;          
          lngEle.value = obj[0].lng;   
          neighborhoodEle.value = obj[0].neighborhood;     
        }else{          
          latEle.value = '';          
          lngEle.value = '';  
		  neighborhoodEle.value = '';        
          callResultDiv.innerHTML = 'Dirección normalizada: '+ obj[0].normalizedAddress+'<br/> Causa: '+obj[0].cause;        
        }      
      }    
    }  
  </script>
</head>
<body>
<table style="width:100%;">
  <form action="">
    <tr>
      <td>Ciudad(ej: Cali) :</td>
      <td>
        <input type="text" id="city" value="Cali"/>
      </td>
    </tr>
    <tr>
      <td>Dir:</td>
      <td>
        <input type="text" id="address" />
      </td>
    </tr>
    <tr>
      <td colspan="2">
        <button onclick="validateAddress();return false;" >Validar</button>
      </td>
    </tr>
    <tr>
      <td>Lat:</td>
      <td>
        <input type="text" id="lat" />
      </td>
    </tr>
    <tr>
      <td>Lng:</td>
      <td>
        <input type="text" id="lng" />
      </td>
    </tr>
    
    <tr>
      <td>Barrio:</td>
      <td>
        <input type="text" id="neighborhood" />
      </td>
    </tr>
    
    <tr>
      <td colspan="2">
        <div style="color:red;" id="call_result">
        </div>
      </td>
    </td>
  </form>
</table>
</body>
</html>
