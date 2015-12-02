IOT control of the Irrigation Valves- PHP based Website
##files' description
* **index.php** - It is the home page and calls control.php through AJAX
   *control.php - It displays group selection and manual control for the valves and calls com.php for sending mqtt commands to esp devices
   *com.php -  It directly interacts with MOSCA broker and publishes ON/OFF commands to esp modules
* **time.php** - It is for automating control of the valves. Provides three types of schedulng tasks  to the user. Calls timetasker.php through AJAX
   *timetasker.php - It interacts woth the MySQL database and adds the entry of scheduled tasks.
* **devdis.php** - It shows group selection option to the user for displaying devices based on their groups and also for updating battery status of each devices. It calls dd.php though AJAX
   *dd.php - It interacts with the MySQL for displaying devices table and also publish commands through MOSCA server for getting battery status from each devices based on their groups.
* **manage.php** - It helps the user in administering devices, adding  groups, find newly discovered devices, adding types of sensors. Calls managedev.php though AJAX
   *managedev.php - It interacts with MySQL database for creating different groups, types of sensors, deleting and updating devices.
* **tasks.php** - It works through cron, parsing tasks table every minute looking for starting and stopping scedules tasks, and also interacts with MOSCA server for publishing ON/OFF commands
* **css.php**  - It is for adding css files in to each php files.
* **spMQTT.class.php** - It is the MQTT class which the project use for interacting with MOSCA server. credit-[sskaje](https://github.com/sskaje/mqtt)
* **subscribe.php**  - It continuously runs in background listening for devices' macids. It helps in updating online status and device discovery
* **battery.php**  - It continuously runs in background listening for battery status from each devices.
* **moisture.php** - It continously runs in background listening for moisture status from each moisture sensors.
* **navigation.php** - It displays menu options
* **app.php** - It displays footer

##Configuring php files for running on different server
* edit iotdb.php for changing mysql server settings
* edit battery.php for changing mysql server settings and mosca server ip
* edit com.php for changing mosca server ip
* edit dd.php for changing mosca server ip
* edit moisture.php for changing mosca server ip and MySQL settings
* edit subscribe.php for changing mosca server ip and MySQL settings
* edit tasks.php for changing mosca server ip

## Publish and subscribe topics format
* server side
	* publish ->
		* ON/OFF/battery- esp/macid , 0 for off, 1 for on, 2 for battery status
	* subscribe ->
		* battery- esp/battery
		* macid- esp
		* moisture- esp/moisture
* esp modules
	* publish ->
		* battery- esp/battery 0 for unhealthy, 1 for healthy
		* moisture- esp/moisture , depends upon calibration,, varies from 200 to 300
	* subscribe ->
		* battery- esp
		* macid- esp
		* moisture- esp/moisture
