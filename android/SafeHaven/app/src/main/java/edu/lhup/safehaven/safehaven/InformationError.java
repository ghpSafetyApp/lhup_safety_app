package edu.lhup.safehaven.safehaven;

/**
 * Created by William on 11/22/2016.
 */
public class InformationError extends Exception {

    String info = null;

    public void set_info(String info){
        this.info = info;
    }

    public String get_info(){
        return info;
    }

}
