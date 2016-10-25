package edu.lhup.safehaven.safehaven;

import android.content.Context;
import android.database.Cursor;
import android.database.DatabaseUtils;
import android.database.sqlite.SQLiteDatabase;
import android.database.sqlite.SQLiteOpenHelper;

/**
 * Created by william on 10/21/16.
 */

public class SQLiteHelper extends SQLiteOpenHelper {

    public static final String DATABASE_NAME = "Data.db";
    public static final String DATA_TABLE_NAME = "data";
    public static final String DATA_ID = "0";
    public static final String DATA_EULA = "0";
    public static final String DATA_HASH = "0";

    public SQLiteHelper(Context context) {
        super(context, DATABASE_NAME, null, 1);
    }

    @Override
    public void onCreate(SQLiteDatabase db) {
        db.execSQL("create table data" + "(data_id int primary key, data_eula int, data_hash text)");
        db.execSQL("insert into data values(1, 0, '')");
    }

    @Override
    public void onUpgrade(SQLiteDatabase db, int oldVersion, int newVersion) {
        // TODO Auto-generated method stub
        db.execSQL("DROP TABLE IF EXISTS data");
        onCreate(db);
    }

    //Checks to see if the EULA was accepted
    public boolean eulaAccepted() {
            SQLiteDatabase db = this.getWritableDatabase();
            Cursor c = db.rawQuery("SELECT data_eula FROM data", null);
            c.moveToFirst();


        int i = 0;
        while(c.isAfterLast() == false){
           i = c.getInt(c.getColumnIndex("data_eula"));
            c.moveToNext();
        }


        if(i == 0){
            return false;
        } else {
            return true;
        }

    }

    public void acceptEula(){
        SQLiteDatabase db = this.getWritableDatabase();
        db.execSQL("UPDATE data SET data_eula = 1");

        return;
    }

    public void setStringHash(String hash){
        SQLiteDatabase db = this.getWritableDatabase();
        db.execSQL("UPDATE data SET data_hash = '" + hash + "'");

        return;
    }

    public String getHash(){
        SQLiteDatabase db = this.getWritableDatabase();
        Cursor c = db.rawQuery("SELECT data_hash FROM data", null);
        c.moveToFirst();


        String hash = null;
        while(c.isAfterLast() == false){
            hash = c.getString(c.getColumnIndex("data_hash"));
            c.moveToNext();
        }

        return hash;

    }


}
