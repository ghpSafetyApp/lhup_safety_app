package edu.lhup.safehaven.safehaven;

import android.util.Base64;

import java.security.Key;

import javax.crypto.Cipher;
import javax.crypto.spec.SecretKeySpec;

/**
 * Created by William on 11/20/2016.
 */

public class Encrypt {

    private static final String ALGORITHM = "AES";
    private static final byte[] keyValue =
            new byte[] { 'Q', 'z', 'l', 'e', 'T', 's', 'N', 'A', 'U', 'p', 'y', 'r', 'm', 'P', 'o', 'w' };

    public String encrypt(String valueToEnc) throws Exception {
        Key key = generateKey();
        Cipher c = Cipher.getInstance(ALGORITHM);
        c.init(Cipher.ENCRYPT_MODE, key);
        byte[] encValue = c.doFinal(valueToEnc.getBytes());

        String encryptedValue = Base64.encodeToString(encValue, Base64.URL_SAFE);
                //getEncoder().encode(encValue));
        return encryptedValue;
    }

    private static Key generateKey() throws Exception {
        Key key = new SecretKeySpec(keyValue, ALGORITHM);
        return key;
    }

}
