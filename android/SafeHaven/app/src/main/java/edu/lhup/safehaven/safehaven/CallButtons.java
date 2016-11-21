package edu.lhup.safehaven.safehaven;

import android.content.Intent;
import android.os.Bundle;
import android.os.Handler;
import android.support.design.widget.FloatingActionButton;
import android.support.design.widget.Snackbar;
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
public class CallButtons extends AppCompatActivity {

    @ViewById(R.id.toolbar)
    Toolbar toolbar;

    @ViewById(R.id.fab)
    FloatingActionButton fab;

    Handler h = new Handler();
    int delay = 5000; //15 seconds
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
        check_connection();

        h.postDelayed(new Runnable() {
            public void run() {

                check_connection();

                runnable=this;

                h.postDelayed(runnable, delay);
            }
        }, delay);

        super.onStart();
    }


    @Click(R.id.fab)
    void fabButtonClick(){
        Intent intent = new Intent(this, Message_.class);
        startActivity(intent);
    }

    @Background
    void check_connection(){
        try{
            URL myUrl = new URL("http://192.168.1.23/");
            URLConnection connection = myUrl.openConnection();

            connection.setConnectTimeout(5000);

            connection.connect();

            update_fab(View.VISIBLE);
            System.out.println("Pass5");

        } catch (Exception e) {
            update_fab(View.INVISIBLE);

        }
    }

    @UiThread
    void update_fab(int value){
        fab.setVisibility(value);
    }
}
