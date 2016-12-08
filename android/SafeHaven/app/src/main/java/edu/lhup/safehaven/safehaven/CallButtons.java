package edu.lhup.safehaven.safehaven;

import android.Manifest;
import android.content.Context;
import android.content.Intent;
import android.content.pm.PackageManager;
import android.location.Location;
import android.location.LocationListener;
import android.location.LocationManager;
import android.net.Uri;
import android.os.Bundle;
import android.os.Handler;
import android.support.design.widget.FloatingActionButton;
import android.support.design.widget.Snackbar;
import android.support.v4.app.ActivityCompat;
import android.support.v4.content.ContextCompat;
import android.support.v7.app.AppCompatActivity;
import android.support.v7.widget.Toolbar;
import android.view.View;

import org.androidannotations.annotations.Background;
import org.androidannotations.annotations.Click;
import org.androidannotations.annotations.EActivity;
import org.androidannotations.annotations.UiThread;
import org.androidannotations.annotations.ViewById;

import java.net.URL;
import java.net.URLConnection;

import static android.R.attr.delay;

@EActivity
public class CallButtons extends AppCompatActivity implements LocationListener {

    @ViewById(R.id.toolbar)
    Toolbar toolbar;

    @ViewById(R.id.fab)
    FloatingActionButton fab;

    public LocationManager locationManager;
    public LocationListener locationListener;
    public String lat = "1";
    public String lng = "1";


    Handler h = new Handler();
    int delay = 15000; //15 seconds
    Runnable runnable;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_call_buttons);

        new EULA(this).show();

        Toolbar toolbar = (Toolbar) findViewById(R.id.toolbar);

        setSupportActionBar(toolbar);

        getSupportActionBar().setDisplayShowHomeEnabled(true);
        getSupportActionBar().setIcon(R.mipmap.ic_launcher);
        getSupportActionBar().setTitle("SafeHaven");

    }

    @Override
    protected void onStart() {
        super.onStart();

        DeviceInfo.createLocationManager(this.getApplicationContext());

        check_connection();

        h.postDelayed(new Runnable() {
            public void run() {

                check_connection();

                runnable = this;

                h.postDelayed(runnable, delay);
            }
        }, delay);

        if (ContextCompat.checkSelfPermission(this,
                Manifest.permission.READ_SMS)
                != PackageManager.PERMISSION_GRANTED) {

            // Should we show an explanation?
            if (ActivityCompat.shouldShowRequestPermissionRationale(this,
                    Manifest.permission.READ_SMS)) {

                // Show an explanation to the user *asynchronously* -- don't block
                // this thread waiting for the user's response! After the user
                // sees the explanation, try again to request the permission.

            } else {

                // No explanation needed, we can request the permission.

                ActivityCompat.requestPermissions(this,
                        new String[]{Manifest.permission.READ_SMS}, 1);

                // MY_PERMISSIONS_REQUEST_READ_CONTACTS is an
                // app-defined int constant. The callback method gets the
                // result of the request.
            }
        }

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

        if (ContextCompat.checkSelfPermission(this,
                Manifest.permission.CALL_PHONE)
                != PackageManager.PERMISSION_GRANTED) {

            // Should we show an explanation?
            if (ActivityCompat.shouldShowRequestPermissionRationale(this,
                    Manifest.permission.CALL_PHONE)) {

                // Show an explanation to the user *asynchronously* -- don't block
                // this thread waiting for the user's response! After the user
                // sees the explanation, try again to request the permission.

            } else {

                // No explanation needed, we can request the permission.

                ActivityCompat.requestPermissions(this,
                        new String[]{Manifest.permission.CALL_PHONE}, 1);

                // MY_PERMISSIONS_REQUEST_READ_CONTACTS is an
                // app-defined int constant. The callback method gets the
                // result of the request.
            }
        }

        locationManager = (LocationManager) getSystemService(Context.LOCATION_SERVICE);


        try {
            locationManager.requestLocationUpdates(LocationManager.GPS_PROVIDER, 1000, 0, this);
        } catch (SecurityException e) {
            return;
        }

        super.onStart();
    }


    @Click(R.id.fab)
    void fabButtonClick() {

        SQLiteHelper db = new SQLiteHelper(getApplicationContext());

        if (db.getUsername().compareTo("") == 0) {
            Intent intent = new Intent(this, Confirm_Device_.class);
            startActivity(intent);
        } else {
            Intent intent = new Intent(this, Message_.class);
            startActivity(intent);
        }


    }

    @Background
    void check_connection() {
        try {
            URL myUrl = new URL("http://151.161.128.207/");
            URLConnection connection = myUrl.openConnection();

            connection.setConnectTimeout(5000);

            connection.connect();

            update_fab(View.VISIBLE);
            System.out.println("Pass5");

        } catch (Exception e) {
            update_fab(View.INVISIBLE);

        }
    }

    @Click(R.id.ps_complaint)
    void psComplaintCall() {
        handleCall(4);
    }

    @Click(R.id.ps_danger)
    void psDangerCall() {
        handleCall(2);
    }

    @Click(R.id.ps_emergency)
    void psEmergencyCall() {
        handleCall(1);
    }

    @Click(R.id.ps_escort)
    void psEscortCall() {
        handleCall(3);
    }

    @Click(R.id.ps_report)
    void psReportCall() {
        handleCall(5);
    }

    @Click(R.id.lp_police)
    void lpPoliceCall() {
        handleCall(6);
    }

    @Click(R.id.wc_womenscenter)
    void womenCenterCall() {
        handleCall(8);
    }

    @Click(R.id.pc_poisoncontrol)
    void pcPoisonControl() {
        handleCall(7);
    }

    private void handleCall(int val) {

        if (ContextCompat.checkSelfPermission(this,
                Manifest.permission.CALL_PHONE)
                != PackageManager.PERMISSION_GRANTED) {

            // Should we show an explanation?
            if (ActivityCompat.shouldShowRequestPermissionRationale(this,
                    Manifest.permission.CALL_PHONE)) {

                // Show an explanation to the user *asynchronously* -- don't block
                // this thread waiting for the user's response! After the user
                // sees the explanation, try again to request the permission.

            } else {

                // No explanation needed, we can request the permission.

                ActivityCompat.requestPermissions(this,
                        new String[]{Manifest.permission.CALL_PHONE}, 1);

                // MY_PERMISSIONS_REQUEST_READ_CONTACTS is an
                // app-defined int constant. The callback method gets the
                // result of the request.
            }
        }

        //0: req_id 1: maccaddress, 2: call type, 3: gps_lat, 4: gps_long, 5:phone
        String message = "4|" + DeviceInfo.getMacAddr() + "|" + val + "|" + lat + "|" + lng + "|" + DeviceInfo.getPhnNum(getApplicationContext());

        SendCallInfo info = new SendCallInfo(message, "Call Data Recieved", getApplicationContext());

        Intent intent = new Intent(Intent.ACTION_CALL);
        intent.setFlags(Intent.FLAG_ACTIVITY_NEW_TASK);
        intent.setData(Uri.parse("tel:15704233039"));


        this.startActivity(intent);

        info.execute();
    }


    @UiThread
    void update_fab(int value){
        fab.setVisibility(value);
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
