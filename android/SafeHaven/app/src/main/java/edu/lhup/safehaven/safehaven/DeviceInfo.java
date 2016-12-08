package edu.lhup.safehaven.safehaven;

import android.content.Context;
import android.location.Location;
import android.location.LocationListener;
import android.location.LocationManager;
import android.os.Bundle;
import android.telephony.TelephonyManager;

import java.net.NetworkInterface;
import java.util.Collections;
import java.util.List;

/**
 * Created by William on 11/22/2016.
 */



public class DeviceInfo {

    public static LocationManager locationManager;
    public static String longitude = null;
    public static String latitude = null;
    public static LocationListener locationListener = null;

    public static void createLocationManager(Context context) {
        locationManager = (LocationManager) context.getSystemService(Context.LOCATION_SERVICE);
        // Define a listener that responds to location updates
        locationListener = new LocationListener() {
            public void onLocationChanged(Location location) {
                location.getLatitude();
                DeviceInfo.longitude = String.valueOf(location.getLongitude());
                DeviceInfo.latitude = String.valueOf(location.getLatitude());
            }

            public void onStatusChanged(String provider, int status, Bundle extras) {
            }

            public void onProviderEnabled(String provider) {
            }

            public void onProviderDisabled(String provider) {
            }

        };

    }

    public static String getMacAddr() {
        try {
            List<NetworkInterface> all = Collections.list(NetworkInterface.getNetworkInterfaces());
            for (NetworkInterface nif : all) {
                if (!nif.getName().equalsIgnoreCase("wlan0")) continue;

                byte[] macBytes = nif.getHardwareAddress();
                if (macBytes == null) {
                    return "";
                }

                StringBuilder res1 = new StringBuilder();
                for (byte b : macBytes) {
                    res1.append(String.format("%02X:",b));
                }

                if (res1.length() > 0) {
                    res1.deleteCharAt(res1.length() - 1);
                }
                return res1.toString();
            }
        } catch (Exception ex) {
        }
        return "02:00:00:00:00:00";
    }

    public static String getPhnNum(Context context) {

        TelephonyManager t = (TelephonyManager) context.getSystemService(Context.TELEPHONY_SERVICE);
        return t.getLine1Number();

    }

    public static int listenForLocation(){
        try {
            locationManager.requestLocationUpdates(LocationManager.GPS_PROVIDER, 0, 0, locationListener);
        } catch(SecurityException e){
            //Return 0 for false permissions
            return 0;
        } catch(Error e){
            //Unknown Error
            return 2;
        }

        return 1;
    }

    public static  int removeListener(){
        // Remove the previously added listener

        try {
            locationManager.removeUpdates(locationListener);
        } catch(SecurityException e){
            //Return 0 for false permissions
            return 0;
        } catch(Error e){
            //Unknown Error
            return 2;
        }

        return 1;
    }


    public static void setNull(){
        DeviceInfo.latitude = null;
        DeviceInfo.longitude = null;
    }
}
