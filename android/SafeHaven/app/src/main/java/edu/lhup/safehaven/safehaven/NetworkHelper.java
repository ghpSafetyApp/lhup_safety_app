package edu.lhup.safehaven.safehaven;

import android.content.Context;

import org.androidannotations.annotations.Background;
import org.androidannotations.annotations.EApplication;
import org.androidannotations.annotations.EBean;

import java.io.InputStream;
import java.net.HttpURLConnection;
import java.net.URL;

/**
 * Created by William on 11/22/2016.
 */

public class NetworkHelper {


    public static void sendMessage(String data, String success, Context context) {

        try{
            //  Encrypt enc = new Encrypt();
            URL myUrl = new URL("http://192.168.1.23/SCRIPTS/http://192.168.1.23/SCRIPTS/mobile_requests/receive_request.php");

            HttpURLConnection con = (HttpURLConnection)  myUrl.openConnection();

            con.setRequestMethod("POST");

            con.setDoInput(true);

            con.setDoOutput(true);

            con.connect();

            con.getOutputStream().write( ("request_string=" + data).getBytes());

            InputStream is = con.getInputStream();

            byte[] b = new byte[1024];

            StringBuffer buffer = new StringBuffer();
            while ( is.read(b) != -1) {
                buffer.append(new String(b));
            }
            con.disconnect();

            if(b.toString().compareTo("1") == 0){

            } else {
                Utilities.showToast(context, getMessage(Integer.getInteger(b.toString())));
            }
        } catch (Exception e) {


        }
    }


    public static void sendCheck(String data){

        int result = 1;

        try{
            //  Encrypt enc = new Encrypt();
            URL myUrl = new URL("http://192.168.1.23/SCRIPTS/mobile_requests/receive_request.php");

            HttpURLConnection con = (HttpURLConnection)  myUrl.openConnection();

            con.setRequestMethod("POST");

            con.setDoInput(true);

            con.setDoOutput(true);

            con.connect();

            con.getOutputStream().write( ("request_string=" + data).getBytes());

            InputStream is = con.getInputStream();

            byte[] b = new byte[1024];

            StringBuffer buffer = new StringBuffer();
            while ( is.read(b) != -1) {
                buffer.append(new String(b));
            }
            con.disconnect();

            if(b.toString().compareTo("1") == 0){

               result = 1;
            } else {
                result = 0;
            }
        } catch (Exception e) {

        }
    }



    public static String getMessage(Integer val){

        switch(val){

            case 2:
                return "Error sending message";

            case 3:
               return "Database Error";

            case 4:
                return "Password/Username Incorrect";
            case 5:
                return "User already exists";
            case 6:
                return "User Already Confirmed";
            case 7:
                return "Credentials do not meet specifications";
            case 8:
                return "Account Banned";
            case 9:
                return "Device Registered";
            case 10:
                return "This device was registered to someone else";
            case 11:
                return "Device already registered, updating database";
            case 12:
                return "Confirmation Email Sent";
            case 13:
                return "Resent Confirmation Email";
            case 14:
                return "Invalid Email Address";
            case 15:
                return "Image failed to upload";
            case 16:
                return "Device not found";
            case 17:
                return "Message failed to upload";
            default:
                return "Unknown Error";
        }

    }


}
