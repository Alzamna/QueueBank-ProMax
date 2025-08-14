<?php

if (!function_exists('detect_device_type')) {
    /**
     * Detect if the current device is mobile or desktop
     * @return string 'mobile' or 'desktop'
     */
    function detect_device_type()
    {
        $user_agent = $_SERVER['HTTP_USER_AGENT'] ?? '';
        
        // Mobile device patterns
        $mobile_patterns = [
            'Mobile', 'Android', 'iPhone', 'iPad', 'Windows Phone',
            'BlackBerry', 'Opera Mini', 'IEMobile', 'Mobile Safari'
        ];
        
        foreach ($mobile_patterns as $pattern) {
            if (stripos($user_agent, $pattern) !== false) {
                return 'mobile';
            }
        }
        
        return 'desktop';
    }
}

if (!function_exists('generate_device_id')) {
    /**
     * Generate unique device ID for mobile devices
     * @return string
     */
    function generate_device_id()
    {
        $device_type = detect_device_type();
        
        if ($device_type === 'mobile') {
            // For mobile, try to get from session first
            $session = session();
            $device_id = $session->get('device_id');
            
            if (!$device_id) {
                // Generate new device ID
                $device_id = 'mobile_' . uniqid() . '_' . time();
                $session->set('device_id', $device_id);
            }
            
            return $device_id;
        }
        
        // For desktop, return null (no persistent device ID needed)
        return null;
    }
}

if (!function_exists('get_client_ip')) {
    /**
     * Get client IP address
     * @return string
     */
    function get_client_ip()
    {
        $ip_keys = ['HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'REMOTE_ADDR'];
        
        foreach ($ip_keys as $key) {
            if (array_key_exists($key, $_SERVER) === true) {
                foreach (explode(',', $_SERVER[$key]) as $ip) {
                    $ip = trim($ip);
                    if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) !== false) {
                        return $ip;
                    }
                }
            }
        }
        
        return $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';
    }
}
