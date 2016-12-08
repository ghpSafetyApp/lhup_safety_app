package edu.lhup.safehaven.safehaven;

import android.Manifest;
import android.content.Context;
import android.content.Intent;
import android.content.pm.PackageManager;
import android.graphics.Bitmap;
import android.graphics.BitmapFactory;
import android.location.Location;
import android.location.LocationListener;
import android.location.LocationManager;
import android.net.Uri;
import android.os.PersistableBundle;
import android.provider.MediaStore;
import android.support.v4.app.ActivityCompat;
import android.support.v4.content.ContextCompat;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.util.Base64;
import android.view.View;
import android.widget.EditText;
import android.widget.ImageView;
import android.widget.TextView;


import org.androidannotations.annotations.Background;
import org.androidannotations.annotations.Click;
import org.androidannotations.annotations.EActivity;
import org.androidannotations.annotations.ViewById;

import java.io.BufferedInputStream;
import java.io.BufferedOutputStream;
import java.io.ByteArrayOutputStream;
import java.io.DataOutputStream;
import java.io.InputStream;
import java.io.OutputStream;
import java.net.HttpURLConnection;
import java.net.URL;
import java.net.URLConnection;

@EActivity()
public class Message extends AppCompatActivity implements LocationListener {


    public LocationManager locationManager;
    public LocationListener locationListener;
    private static final int CAMERA_REQUEST = 1;
    public String lat = "1";
    public String lng = "1";
    public Bitmap message_image = null;

    Uri selectedImage = null;

    @ViewById(R.id.message_text)
    EditText text_field;

    @ViewById(R.id.message_image)
    ImageView image;

    @ViewById(R.id.message_image_click)
    TextView label;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_message);

        if (ContextCompat.checkSelfPermission(this,
                Manifest.permission.ACCESS_COARSE_LOCATION)
                != PackageManager.PERMISSION_GRANTED) {

            // Should we show an explanation?
            if (ActivityCompat.shouldShowRequestPermissionRationale(this,
                    Manifest.permission.ACCESS_COARSE_LOCATION)) {

                // Show an explanation to the user *asynchronously* -- don't block
                // this thread waiting for the user's response! After the user
                // sees the explanation, try again to request the permission.

            } else {

                // No explanation needed, we can request the permission.

                ActivityCompat.requestPermissions(this,
                        new String[]{Manifest.permission.ACCESS_COARSE_LOCATION}, 1);

                // MY_PERMISSIONS_REQUEST_READ_CONTACTS is an
                // app-defined int constant. The callback method gets the
                // result of the request.
            }
        }

        if (ContextCompat.checkSelfPermission(this,
                Manifest.permission.ACCESS_FINE_LOCATION)
                != PackageManager.PERMISSION_GRANTED) {

            // Should we show an explanation?
            if (ActivityCompat.shouldShowRequestPermissionRationale(this,
                    Manifest.permission.ACCESS_FINE_LOCATION)) {

                // Show an explanation to the user *asynchronously* -- don't block
                // this thread waiting for the user's response! After the user
                // sees the explanation, try again to request the permission.

            } else {

                // No explanation needed, we can request the permission.

                ActivityCompat.requestPermissions(this,
                        new String[]{Manifest.permission.ACCESS_FINE_LOCATION}, 1);

                // MY_PERMISSIONS_REQUEST_READ_CONTACTS is an
                // app-defined int constant. The callback method gets the
                // result of the request.
            }
        }

        locationManager = (LocationManager) getSystemService(Context.LOCATION_SERVICE);


        try {
            locationManager.requestLocationUpdates(LocationManager.GPS_PROVIDER, 0, 0, this);
        } catch (SecurityException e) {
            return;
        }
    }

    @Click(R.id.message_image_click)
    void getCamera() {


        Intent cameraIntent = new Intent(android.provider.MediaStore.ACTION_IMAGE_CAPTURE);
        startActivityForResult(cameraIntent, CAMERA_REQUEST);

    }

    @Click(R.id.message_send)
    void sendMessage() {


        ByteArrayOutputStream stream = new ByteArrayOutputStream();

        String image_str = "n";

        if(message_image != null) {

            message_image.compress(Bitmap.CompressFormat.PNG, 90, stream);

            byte[] image_bytes = stream.toByteArray();

            image_str = Base64.encodeToString(image_bytes, Base64.DEFAULT);

        }

        String text = text_field.getText().toString();

        String prepareString = "5|" + DeviceInfo.getMacAddr() + "|" + text + "|" + lat + "|" + lng + "|" + image_str;

        System.out.println(prepareString);

        SendMessage msg = new SendMessage(prepareString, "Message received", getApplicationContext(), this);

        msg.execute();

    }

    protected void onActivityResult(int requestCode, int resultCode, Intent data) {
        if (requestCode == CAMERA_REQUEST && resultCode == RESULT_OK) {
            label.setText("");
            message_image = (Bitmap) data.getExtras().get("data");
            image.setImageBitmap(message_image);
        }
    }

    public void finishActivity() {
        finish();
    }

    @Override
    public void onLocationChanged(Location location) {
        if (location != null) {

            lat = Double.toString(location.getLatitude());
            lng = Double.toString(location.getLongitude());
        } else {
            try {
                Location loc = locationManager.getLastKnownLocation(LocationManager.GPS_PROVIDER);
                lat = Double.toString(loc.getLatitude());
                lng = Double.toString(location.getLongitude());
            } catch (SecurityException e) {
                //Return 0 for false permissions
                return;
            }
        }

    }

    @Override
    public void onStatusChanged(String s, int i, Bundle bundle) {

    }

    @Override
    public void onProviderEnabled(String s) {

    }

    @Override
    public void onProviderDisabled(String s) {

    }

}
