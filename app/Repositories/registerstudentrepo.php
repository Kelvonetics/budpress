<?php
namespace App\Repositories;
use App\User;

class registerstudentrepo{
	
	const METHOD = 'aes-256-ctr';

	public function addstudent(array $data){
		
		$createuser=User::create($data);
		if($createuser){
			
			return 'success';
		}
		else{
			return 'failure';
		}
		
	}
   public function randogen(){

		$salt1=array_rand(['qil$'=>'lo%v','bR3$'=>'6*g$','m&4%'=>'%','oN$A'=>'A','+kl5'=>'5','n0Mh'=>'h']);
		$salt2=array_rand(['Wc@d'=>'W','v)b^'=>'^','£%^&'=>'&','BcXG'=>'G','cx/eb'=>'b','ObT*'=>'O']);
		$salt3=array_rand(['rBmG'=>'r','M456f'=>'-','889R'=>'8','V443'=>'V','1564'=>'l','4509'=>'Q']);
		 
		$envensalt=rand(1000,2000);
		$randgen=$envensalt*2;
		$randgen2=$envensalt*3;

		return  $salt1.'-'.$randgen.'-'.$salt2.'-'.$randgen2.'-'.$salt3;
	}
 
    /**
     * Encrypts (but does not authenticate) a message
     * 
     * @param string $message - plaintext message
     * @param string $key - encryption key (raw binary expected)
     * @param boolean $encode - set to TRUE to return a base64-encoded 
     * @return string (raw binary)
     */
    public  function encrypt($message, $key, $encode = false)
    {
        $nonceSize = openssl_cipher_iv_length(self::METHOD);
        $nonce = openssl_random_pseudo_bytes($nonceSize);

        $ciphertext = openssl_encrypt(
            $message,
            self::METHOD,
            $key,
            OPENSSL_RAW_DATA,
            $nonce
        );

        // Now let's pack the IV and the ciphertext together
        // Naively, we can just concatenate
        if ($encode) {
            return base64_encode($nonce.$ciphertext);
        }
        return $nonce.$ciphertext;
    }

    /**
     * Decrypts (but does not verify) a message
     * 
     * @param string $message - ciphertext message
     * @param string $key - encryption key (raw binary expected)
     * @param boolean $encoded - are we expecting an encoded string?
     * @return string
     */
    public  function decrypt($message, $key, $encoded = false)
    {
        if ($encoded) {
            $message = base64_decode($message, true);
            if ($message === false) {
                throw new Exception('Encryption failure');
            }
        }

        $nonceSize = openssl_cipher_iv_length(self::METHOD);
        $nonce = mb_substr($message, 0, $nonceSize, '8bit');
        $ciphertext = mb_substr($message, $nonceSize, null, '8bit');

        $plaintext = openssl_decrypt(
            $ciphertext,
            self::METHOD,
            $key,
            OPENSSL_RAW_DATA,
            $nonce
        );

        return $plaintext;
    }
	
	
	
}