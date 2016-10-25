package edu.lhup.safehaven.safehaven;

import android.content.Context;

import android.widget.Toast;

import java.net.NetworkInterface;
import java.security.MessageDigest;
import java.security.NoSuchAlgorithmException;
import java.util.Collections;
import java.util.List;

/**
 * Created by william on 10/23/16.
 */

public class Utilities {

    private Toast toast;

    public void showToast(Context context, String text) {
        if (toast != null) toast.cancel();
        toast = Toast.makeText(context, text, Toast.LENGTH_LONG);
        toast.show();
    }

    public String generateHash(Context context, String username) {

        try {
            List<NetworkInterface> interfaces = Collections.list(NetworkInterface.getNetworkInterfaces());
            for (NetworkInterface intf : interfaces) {
                if ("wlan0" != null) {
                    if (!intf.getName().equalsIgnoreCase("wlan0")) continue;
                }
                byte[] mac = intf.getHardwareAddress();
                if (mac == null) return "";
                StringBuilder buf = new StringBuilder();
                for (int idx = 0; idx < mac.length; idx++)
                    buf.append(String.format("%02X:", mac[idx]));
                if (buf.length() > 0) buf.deleteCharAt(buf.length() - 1);
                username += buf.toString();
            }
        } catch (Exception ex) {
            return null;
        } // for now eat exceptions


        MessageDigest messageDigest = null;

        String encryptedString = null;
        try {
            messageDigest = MessageDigest.getInstance("SHA-256");

            messageDigest.update(username.getBytes());
            encryptedString = new String(messageDigest.digest());

        } catch (NoSuchAlgorithmException e) {
            e.printStackTrace();
            return null;
        }

        return encryptedString;

    }
}