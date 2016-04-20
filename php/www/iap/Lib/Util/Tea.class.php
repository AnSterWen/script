<?php
class Tea {
    private static function str2LongArray($str)
    {
        $bin = unpack('C*', $str);
        $arr = array();
        for($i = 1; $i < count($bin); $i += 4) {
            $arr[] = ($bin[$i] << 24) + ($bin[$i+1] << 16) + ($bin[$i+2] << 8) + $bin[$i+3];
        }
        return $arr;
    }

    private static function longArray2Str($arr)
    {
        $str = '';
        foreach ($arr as $v) {
            $str .= chr($v >> 24).chr(($v >> 16)&0xFF).chr(($v>>8)&0xFF).chr($v&0xFF);
        }
        return $str;
    }

    static function encrypt($data, $key)
    {
        $len = strlen($data);
        $pos = ($len + 10) % 8;
        if ($pos != 0) {
            for ($i = 0; $i < $pos; $i ++)
                $data = chr(0).$data;
            $pos = 8 - $pos;
            $data = chr($pos).$data;
        }
        $len += $pos + 10;
        for ($pos = strlen($data); $pos < $len; $pos ++)
            $data .= chr(0);

        for ($pos = strlen($key); $pos < 16; $pos ++)
            $key .= chr(0);

        $darr = self::str2LongArray($data);
        $karr = self::str2LongArray($key);
        $oarr = array();

        for ($i = 0; $i < count($darr); $i += 2) {
            if ($i != 0) {
                $darr[$i] ^= $oarr[$i-2];
                $darr[$i+1] ^= $oarr[$i-2+1];
            }

            $y = $darr[$i];
            $z = $darr[$i + 1];

            $sum = ( integer ) 0;
            for ($j = 0; $j < 16; $j ++) {
                $sum += 0x9E3779B9;
                $sum &= 0xFFFFFFFF;
                $y += (($z << 4) + $karr[0]) ^ ($z + $sum) ^ (($z >> 5) + $karr[1]);
                $y &= 0xFFFFFFFF;
                $z += (($y << 4) + $karr[2]) ^ ($y + $sum) ^ (($y >> 5) + $karr[3]);
                $z &= 0xFFFFFFFF;
            }

            if ($i != 0) {
                $y ^= $darr[$i-2];
                $z ^= $darr[$i-2+1];
            }
            $oarr[] = $y;
            $oarr[] = $z;
        }

        $str = self::longArray2Str($oarr);
        return base64_encode($str);
    }
};
