package edu.lhup.safehaven.safehaven;

import android.content.Intent;
import android.graphics.Bitmap;
import android.net.Uri;
import android.os.PersistableBundle;
import android.provider.MediaStore;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.widget.ImageView;
import android.widget.TextView;

import org.androidannotations.annotations.Click;
import org.androidannotations.annotations.EActivity;
import org.androidannotations.annotations.ViewById;

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
        finish();
    }

    protected void onActivityResult(int requestCode, int resultCode, Intent data) {
        if (requestCode == CAMERA_REQUEST && resultCode == RESULT_OK) {
            label.setText("");
            Bitmap photo = (Bitmap) data.getExtras().get("data");
            image.setImageBitmap(photo);
        }
    }

}
