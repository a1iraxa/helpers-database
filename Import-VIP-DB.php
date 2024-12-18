Import VIP DB:

	- unzip db
	- update prefix with ( sed -e 's/wp_6/wp_9/g' ./hn-us-live-db-backup.sql > hn-ca-db-backup.sql )
	- search-replace with ( vip search-replace ./hn-ca-db-backup.sql --search-replace="historic-newspapers.com,signaturegifts-staging.go-vip.net/hn-ca" )
	- generate gzip with ( gzip -9 hn-ca-db-backup.sql )
	- start import ( vip @signaturegifts.staging import sql ./hn-ca-db-backup.sql.gz )