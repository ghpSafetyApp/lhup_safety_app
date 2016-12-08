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
 * Created by William on 12/6/2016.
 */

public class SendCallInfo extends AsyncTask<Void, Void, Void> {


    String data;
    String toast;
    String success;
    Context context;

    int result;

    public SendCallInfo(String data, String success, Context context){
        this.data = data;
        this.success = success;
        this.context = context;

    }

    @Override
    protected Void doInBackground(Void... voids) {

        try{
            //  Encrypt enc = new Encrypt();
            URL myUrl = new URL("http://151.161.128.207/SCRIPTS/mobile_requests/receive_request.php");

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

                toast = success;
                result = 1;
            } else {

                toast= "" + NetworkHelper.getMessage(Integer.getInteger(response));
            }
        } catch (Exception e) {
            e.printStackTrace();
            toast = "An unknown error occured.";
        }

        return null;
    }

    @Override
    protected void onPostExecute(Void aVoid) {

        Utilities.showToast(context, toast);

    }


}
