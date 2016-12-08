package edu.lhup.safehaven.safehaven;

import android.Manifest;
import android.content.Context;
import android.content.pm.PackageManager;
import android.os.PersistableBundle;
import android.support.v4.app.ActivityCompat;
import android.support.v4.content.ContextCompat;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.widget.EditText;
import android.widget.ImageView;
import android.widget.TextView;

import org.androidannotations.annotations.Background;
import org.androidannotations.annotations.Click;
import org.androidannotations.annotations.EActivity;
import org.androidannotations.annotations.ViewById;

import java.io.InputStream;
import java.net.HttpURLConnection;
import java.net.URL;

@EActivity(R.layout.activity_confirm)
public class Confirm_Device extends AppCompatActivity {


    @ViewById(R.id.txt_user_username)
    EditText username;

    @ViewById(R.id.txt_user_password)
    EditText password;

    @Click(R.id.user_device_submit)
    void sendMessage(){

        if(username.getText().toString().length() == 0){
            Utilities.showToast(getApplicationContext(), "User name was empty");
            return;
        }

        if(password.getText().toString().length() == 0){
            Utilities.showToast(getApplicationContext(), "Password was empty");
            return;
        }





            String text = null;

        String prepareString = "2|" + username.getText().toString() + "|" + password.getText().toString() + "|" + DeviceInfo.getMacAddr() + "|" + DeviceInfo.getPhnNum(getApplicationContext());

        AddDevice d = new AddDevice(prepareString, "Device Registered", username.getText().toString(), password.getText().toString(),getApplicationContext(), this);

        d.execute();

        DeviceInfo.setNull();

        //finish();
    }

    public void finishActivity(){
        finish();
    }


}
