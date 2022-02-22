# healthmonitoringsystem


- Our project of Health Monitoring System reduces efforts of  most of the health workers like doctors and nurses.
By implementing our project chances of critical patient survival will increase and also, it is good for old-aged people 
who go to the hospital for regular diagnosis.They do not need to go regularly hospital for checkups. 
- Using our health monitoring kit they are able to check themselves from home and they are also able to communicate with 
doctors as we put options for asking a doctor. So, in short, our project will improve the quality of the health industry.



## How does our system work?

- when we attach different sensors like ECG, temperature, Oximeter, etc. to the human body it will measure those values from 
the human body and we have used ESP8266 Wifi module with help of this wifi module and our developed APIs those data will 
be sent to our webserver. 
- From the webserver, those data are fetched and displayed on our website in the graph format that we have made.
Both doctors and patients are able to see their respective data and take actions according to it.



<h3 align="left">Languages and Tools Used:</h3>
<p align="left"> <a href="https://getbootstrap.com" target="_blank"> <img src="https://raw.githubusercontent.com/devicons/devicon/master/icons/bootstrap/bootstrap-plain-wordmark.svg" alt="bootstrap" width="40" height="40"/> </a> <a href="https://www.w3schools.com/css/" target="_blank"> <img src="https://raw.githubusercontent.com/devicons/devicon/master/icons/css3/css3-original-wordmark.svg" alt="css3" width="40" height="40"/> </a> <a href="https://www.djangoproject.com/" target="_blank"> <img src="https://raw.githubusercontent.com/devicons/devicon/master/icons/django/django-original.svg" alt="django" width="40" height="40"/> </a> <a href="https://www.w3.org/html/" target="_blank"> <img src="https://raw.githubusercontent.com/devicons/devicon/master/icons/html5/html5-original-wordmark.svg" alt="html5" width="40" height="40"/> </a>  <a href="https://www.mysql.com/" target="_blank"> <img src="https://raw.githubusercontent.com/devicons/devicon/master/icons/mysql/mysql-original-wordmark.svg" alt="mysql" width="40" height="40"/> </a> <a href="https://www.python.org" target="_blank"> <img src="https://raw.githubusercontent.com/devicons/devicon/master/icons/python/python-original.svg" alt="python" width="40" height="40"/> </a> <a href="https://www.php.net" target="_blank"> <img src="https://raw.githubusercontent.com/devicons/devicon/master/icons/php/php-original.svg" alt="php" width="40" height="40"/> </a> </p>

<h3 align="left">Sensors Used:</h3>
<p align="left">
<img src="https://github.com/Dhruvkumar0463/Health-Monitoring_System/blob/master/IOT%20CODE/esp8266.jpg" alt="esp8266" width="200" height="150"/>
<img src="https://github.com/parthparikh02/healthmonitoringsystem/blob/master/IOT%20CODE/MLX.jpg" alt="MLX" width="200" height="150"/>
<img src="https://github.com/parthparikh02/healthmonitoringsystem/blob/master/IOT%20CODE/AD8232_ECG.jpg" alt="AD8232_ECG" width="200" height="150"/>
<img src="https://github.com/parthparikh02/healthmonitoringsystem/blob/master/IOT%20CODE/MAX30100.jpg" alt="MAX30100" width="200" height="150"/>
</p>

<h3 align="left">Sensors Connections:</h3>
<table class="tftable" border="1">
<tr><th>Sensor Name</th><th>Vin</th><th>GND</th><th>SCL</th><th>SDA</th><th>OUTPUT</th></tr>
<tr><td>MAX30100</td><td> 3.3V </td><td> GND </td><td> D1 </td><td> D2 </td><td> - </td></tr>
<tr><td>AD8232</td><td> 3.3V </td><td> GND </td><td> - </td><td> - </td><td> A0 </td></tr>
<tr><td>MLX</td><td> 3.3V </td><td> GND </td><td> D1 </td><td> D1 </td><td> - </td></tr>

</table>


<h3 align="left">ECG sensor attachment to the body:</h3>
<p align="left">
<img src="https://github.com/parthparikh02/healthmonitoringsystem/blob/master/IOT%20CODE/ecg_placement.jpg" alt="ecg" width="400" height="200"/>
</p>

<mark><h3 align="left">UI Demo:</h3></mark>
<p align="left">
<h4>&#x25CF; Doctor Profile:</h4>
<img src="https://github.com/parthparikh02/healthmonitoringsystem/blob/master/Django%20Code/Screenshots/docdahboard.PNG" alt="docdahboard" />
<img src="https://github.com/parthparikh02/healthmonitoringsystem/blob/master/Django%20Code/Screenshots/docecg.PNG" alt="docecg" />
<img src="https://github.com/parthparikh02/healthmonitoringsystem/blob/master/Django%20Code/Screenshots/docpulserate.PNG" alt="docpulserate" />
<img src="https://github.com/parthparikh02/healthmonitoringsystem/blob/master/Django%20Code/Screenshots/docspo2.PNG" alt="docspo2" />
<img src="https://github.com/parthparikh02/healthmonitoringsystem/blob/master/Django%20Code/Screenshots/doctemp.PNG" alt="doctemp" />
<h4>&#x25CF; Patient Profile:</h4>
<img src="https://github.com/parthparikh02/healthmonitoringsystem/blob/master/Django%20Code/Screenshots/patient_dashboard.PNG" alt="patient_dashboard" />
<img src="https://github.com/parthparikh02/healthmonitoringsystem/blob/master/Django%20Code/Screenshots/ECG.PNG" alt="ecg" />
<img src="https://github.com/parthparikh02/healthmonitoringsystem/blob/master/Django%20Code/Screenshots/pulserate.PNG" alt="pulserate" />
<img src="https://github.com/parthparikh02/healthmonitoringsystem/blob/master/Django%20Code/Screenshots/spo2.PNG" alt="spo2" />
<img src="https://github.com/parthparikh02/healthmonitoringsystem/blob/master/Django%20Code/Screenshots/temp.PNG" alt="temp" />
</p>
