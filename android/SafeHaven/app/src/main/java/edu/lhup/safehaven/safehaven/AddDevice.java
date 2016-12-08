package edu.lhup.safehaven.safehaven;

import android.content.Context;
import android.os.AsyncTask;

import java.io.BufferedInputStream;
import java.io.BufferedReader;
import java.io.InputStream;
import java.io.InputStreamReader;
import java.net.HttpURLConnection;
import java.net.URL;

/**
 * Created by William on 11/22/2016.
 */

public class AddDevice extends AsyncTask<Void, Void, Void> {

    Context context;
    String data;
    String success;
    String usenm;
    String password;
    String toast;
    Confirm_Device dev;
    int result = 0;

    public AddDevice(String data, String success, String username, String password, Context context, Confirm_Device dev){
        this.data = data;
        this.success = success;
        this.usenm = username;
        this.password = password;
        this.context = context;
        this.dev = dev;
    }

    @Override
    protected Void doInBackground(Void... voids) {

        try{
            //  Encrypt enc = new Encrypt();
            URL myUrl = new URL("http://151.161.128.207/SCRIPTS/mobile_requests/receive_request.php");
            //192.168.1.23

            HttpURLConnection con = (HttpURLConnection)  myUrl.openConnection();

            con.setRequestMethod("POST");

            con.setDoInput(true);

            con.setDoOutput(true);

            con.connect();

            con.getOutputStream().write( ("request_string=" + data).getBytes());



            InputStream responseStream = new
                    BufferedInputStream(con.getInputStream());

            BufferedReader responseStreamReader =
                    new BufferedReader(new InputStreamReader(responseStream));

            String line = "";
            StringBuilder stringBuilder = new StringBuilder();

            while ((line = responseStreamReader.readLine()) != null) {
                stringBuilder.append(line);
            }
            responseStreamReader.close();

            String response = stringBuilder.toString();

//  Close response stream:

            responseStream.close();
            con.disconnect();

            if(response.compareTo("1") == 0){
                SQLiteHelper db = new SQLiteHelper(context);
                db.setUsername(usenm);
                db.setPassword(password);
               toast = "Device added successfully";
                result = 1;
            } else {

                toast= "" + NetworkHelper.getMessage(Integer.getInteger(response));
            }
        } catch (Exception e) {
            e.printStackTrace();
            toast = "There was an exception";
        }

        return null;
    }

    @Override
    protected void onPostExecute(Void aVoid) {

        Utilities.showToast(context, toast);

        if(result == 1){
            dev.finishActivity();
        }

    }
}
