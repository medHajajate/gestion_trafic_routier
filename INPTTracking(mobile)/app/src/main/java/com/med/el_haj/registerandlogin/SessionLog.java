package com.med.el_haj.registerandlogin;

import android.content.Context;
import android.content.SharedPreferences;
import android.preference.PreferenceManager;

/**
 * Created by EL-HAJ on 5/19/2016.
 */
public class SessionLog {

    private SharedPreferences sp;
    private SharedPreferences.Editor spEditor;

    public SessionLog(Context context) {
        sp = PreferenceManager.getDefaultSharedPreferences(context);

    }

    public boolean setLogin(boolean status) {
        spEditor = sp.edit();
        spEditor.putBoolean("is_logged_in", status);
        spEditor.commit();
        return true;
    }

    public boolean getLoggedIn() {
        return sp.getBoolean("is_logged_in", false);
    }
}
