    <?php
    /**
     * Create hash
     *
     * @param string $service_domain
     * The CDN Service Domain, eg. cdn.mycompany.com
     * @param string $file_path
     * File path of the CDN service content
     * @param string $url_signing_key
     * The URL Signing Key that is obtained from the CDN service property at Services/Settings
     * @param int $expiry_timestamp [optional]
     * UNIX timestamp format, specify how long the hash link is accessible to the public
     * By default will be accessible forever.
     *
     * @return string URL with generated hash link
     * URL with designated format to access the CDN service content
     *
     * Example:
     * Generate hash link for CDN service cdn.mycompany.com/images/photo.png for next 3 days, assume today is Sun, 01 Apr 2012
     *
     *
     * $hash_link = generateHashLink('cdn.mycompany.com', '/images/photo.png', 'l3cewcccol', 1333497600);
     *
     * print $hash_link;
     *
     *
     * http://cdn.mycompany.com/images/photo.png?secure=kaGd_cu6KOfrëfeIy4deddfe4X3jy5Rw==,1333497600
     * 
     */


    function generateHashLink($service_domain, $file_path, $url_signing_key ,$expiry_timestamp = NULL){
 
        // + and /  are some of represented chars of based64 encoding (8 bits)
        // + is 62 and / is 63 and these char should be replaced by other predefined chars
        $search_chars = array('+','/');
        $replace_chars = array('-', '_');
 
        if($file_path[0] != '/'){
            $file_path = "/{$file_path}";
        }
 
        if($pos =  strpos($file_path, '?')){
            $file_path = substr($file_path, 0, $pos);
        }
 
        $hash_string = $file_path.$url_signing_key;
 
        if($expiry_timestamp){
            $hash_string = $expiry_timestamp.$hash_string;
            $expiry_timestamp = ",{$expiry_timestamp}";
        }
 
        return  "http://{$service_domain}{$file_path}?secure=".
                str_replace($search_chars, $replace_chars, base64_encode(md5($hash_string, TRUE))).
                $expiry_timestamp;
    }

    // END
