package edu.lhup.safehaven.safehaven;

import android.content.Context;
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
    }

    @Override
    public void onUpgrade(SQLiteDatabase db, int oldVersion, int newVersion) {
        // TODO Auto-generated method stub
        db.execSQL("DROP TABLE IF EXISTS data");
        onCreate(db);
    }

    public boolean tableExists() {
        SQLiteDatabase db = this.getReadableDatabase();
        int numRows = (int) DatabaseUtils.queryNumEntries(db,
                DATA_TABLE_NAME);
        db.close();

        if(numRows > 0){
            return true;
        } else {
            return false;
        }

    }

    


}
