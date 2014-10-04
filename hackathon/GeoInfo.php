<?php
# Collect a specific users GEOIP info
$info = geoip_record_by_name($_SERVER['REMOTE_ADDR']);
print_r ($info);

# To get the info from one specific field
$country = $info['country_name'];
echo $country;

# To combine information from the array into a string
$info = implode("/", $info);
echo $info;
?>