package edu.lhup.safehaven.safehaven;

import android.content.Intent;
import android.graphics.Bitmap;
import android.net.Uri;
import android.os.PersistableBundle;
import android.provider.MediaStore;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.view.View;
import android.widget.ImageView;
import android.widget.TextView;


import org.androidannotations.annotations.Background;
import org.androidannotations.annotations.Click;
import org.androidannotations.annotations.EActivity;
import org.androidannotations.annotations.ViewById;

import java.io.BufferedInputStream;
import java.io.BufferedOutputStream;
import java.io.DataOutputStream;
import java.io.InputStream;
import java.io.OutputStream;
import java.net.HttpURLConnection;
import java.net.URL;
import java.net.URLConnection;

@EActivity(R.layout.activity_message)
public class Message extends AppCompatActivity {



    private static final int CAMERA_REQUEST = 1;

    Uri selectedImage = null;

    @ViewById(R.id.message_image)
    ImageView image;

    @ViewById(R.id.message_image_click)
    TextView label;

    @Click(R.id.message_image_click)
    void getCamera(){


        Intent cameraIntent = new Intent(android.provider.MediaStore.ACTION_IMAGE_CAPTURE);
        startActivityForResult(cameraIntent, CAMERA_REQUEST);

    }

    @Click(R.id.message_send)
    void sendMessage(){


        tryThing();


        finish();
    }

    protected void onActivityResult(int requestCode, int resultCode, Intent data) {
        if (requestCode == CAMERA_REQUEST && resultCode == RESULT_OK) {
            label.setText("");
            Bitmap photo = (Bitmap) data.getExtras().get("data");
            image.setImageBitmap(photo);
        }
    }

    @Background
    public void tryThing() {

        try{
          //  Encrypt enc = new Encrypt();
            String str = "2|wcg4229|helloworld|somemac|somephone";



            URL myUrl = new URL("http://192.168.1.23/SCRIPTS/mobile_requests/receive_request.php");

            HttpURLConnection con = (HttpURLConnection)  myUrl.openConnection();

            con.setRequestMethod("POST");

            con.setDoInput(true);

            con.setDoOutput(true);

            con.connect();

            con.getOutputStream().write( ("request_string=" + str).getBytes());

            InputStream is = con.getInputStream();

            byte[] b = new byte[1024];

            StringBuffer buffer = new StringBuffer();
            while ( is.read(b) != -1) {
                buffer.append(new String(b));
            }
            con.disconnect();

        } catch (Exception e) {


        }
    }
}
