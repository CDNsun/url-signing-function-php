# Token generator for URL Signing


USAGE
```
UrlSigning.php -s <scheme> -r <CDN domain> -p <file path> -k <URL Signing Key> [-e <expiration time> ] [-i <IP>]
```

PARAMETERS

* scheme  
  * http or https, default = http
* CDN domain
  * CDN service domain
  * example: '12345.r.cdnsun.net'
* file path
  * e.g. '/images/photo.jpeg'
* URL Signing Key
  * URL Signing Key from the https://cdnsun.com/cdn/settings page
  * example: 'jfXNDdkOp2'
* expiration time (optional)
  * expiration time of token, UNIX timestamp format.
  * example: 1333497600
* IP (optional)
  * Allow access only to the specified IP address
  * example: '1.2.3.4'


TO GENERATE TOKEN
```
php UrlSigning.php -s 'http' -r '12345.r.cdnsun.net' -p '/images/photo.jpeg' -k 'jfXNDdkOp2' -e 1333497600 -i '1.2.3.4'
```
Sample Output:
```
http://12345.r.cdnsun.net/images/photo.jpeg?secure=DMF1ucDxtHCxwYQ==
```

CONTACT

* W: https://cdnsun.com
* E: info@cdnsun.com  
