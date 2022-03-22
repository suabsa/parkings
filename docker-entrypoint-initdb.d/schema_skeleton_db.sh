#!/bin/bash
SRC_MYSQL_USER="parkings"
TARGET_MYSQL_PASSWD="parkings"
TARGET_DB_NAME="parkings"

# Automation for country
# Declare currency
declare -A currency
currency["Finland"]="€"
currency["Denmark"]="Kr."
currency["Sweden"]="kr"

#Populate country and currency table
for key in ${!currency[@]}; do
      mysql ${TARGET_DB_NAME} -u${SRC_MYSQL_USER} -p${TARGET_MYSQL_PASSWD} --execute="INSERT INTO country (country, currency) VALUES ('${key}', '${currency[${key}]}')"
done

# For now manually populate data:
countryId=$(mysql ${TARGET_DB_NAME} -u${SRC_MYSQL_USER} -p${TARGET_MYSQL_PASSWD} -s -N --execute="SELECT country_id from country where country='Finland' LIMIT 1")
mysql ${TARGET_DB_NAME} -u${SRC_MYSQL_USER} -p${TARGET_MYSQL_PASSWD} --execute="INSERT INTO owner (country_id, garage_owner, contact_email) VALUES ('$countryId', 'Autopark', 'testemail@testautopark.fi')"
mysql ${TARGET_DB_NAME} -u${SRC_MYSQL_USER} -p${TARGET_MYSQL_PASSWD}  --execute="INSERT INTO owner (country_id, garage_owner, contact_email) VALUES ('$countryId', 'Parkkitalo OY', 'testemail@testgarage.fi')"

# Populating for garages.
autoParkGarageId=$(mysql ${TARGET_DB_NAME} -u${SRC_MYSQL_USER} -p${TARGET_MYSQL_PASSWD} -s -N --execute="SELECT owner_id from owner where garage_owner='Autopark' LIMIT 1")
parkkitaloGarageId=$(mysql ${TARGET_DB_NAME} -u${SRC_MYSQL_USER} -p${TARGET_MYSQL_PASSWD} -s -N --execute="SELECT owner_id from owner where garage_owner='Parkkitalo OY' LIMIT 1")
mysql ${TARGET_DB_NAME} -u${SRC_MYSQL_USER} -p${TARGET_MYSQL_PASSWD} --execute="INSERT INTO garage (owner_id, name, point, hourly_price) VALUES ('$autoParkGarageId', 'Garage1', '60.168607847624095 24.932371066131623', '2')"
mysql ${TARGET_DB_NAME} -u${SRC_MYSQL_USER} -p${TARGET_MYSQL_PASSWD} --execute="INSERT INTO garage (owner_id, name, point, hourly_price) VALUES ('$autoParkGarageId', 'Garage2', '60.16444996645511 24.938178168200714', '1.5')"
mysql ${TARGET_DB_NAME} -u${SRC_MYSQL_USER} -p${TARGET_MYSQL_PASSWD} --execute="INSERT INTO garage (owner_id, name, point, hourly_price) VALUES ('$autoParkGarageId', 'Garage3', '60.165219358852795 24.93537425994873', '2')"
mysql ${TARGET_DB_NAME} -u${SRC_MYSQL_USER} -p${TARGET_MYSQL_PASSWD} --execute="INSERT INTO garage (owner_id, name, point, hourly_price) VALUES ('$autoParkGarageId', 'Garage4', '60.16444996645511 24.938178168200714', '3')"
mysql ${TARGET_DB_NAME} -u${SRC_MYSQL_USER} -p${TARGET_MYSQL_PASSWD} --execute="INSERT INTO garage (owner_id, name, point, hourly_price) VALUES ('$autoParkGarageId', 'Garage5', '60.17167429490068 24.921585662024363', '3')"
mysql ${TARGET_DB_NAME} -u${SRC_MYSQL_USER} -p${TARGET_MYSQL_PASSWD} --execute="INSERT INTO garage (owner_id, name, point, hourly_price) VALUES ('$parkkitaloGarageId', 'Garage6', '60.16867390148751 24.930162952045407', '2')"

