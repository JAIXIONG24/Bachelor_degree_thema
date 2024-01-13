package com.example.trainingtime;

import androidx.appcompat.app.AppCompatActivity;

import android.annotation.SuppressLint;
import android.content.Intent;
import android.os.Bundle;
import android.view.View;
import android.widget.ArrayAdapter;
import android.widget.Button;
import android.widget.EditText;
import android.widget.RadioButton;
import android.widget.RadioGroup;
import android.widget.Spinner;
import android.widget.TextView;
import android.widget.Toast;

import com.android.volley.AuthFailureError;
import com.android.volley.Request;
import com.android.volley.RequestQueue;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.StringRequest;
import com.android.volley.toolbox.Volley;

import org.json.JSONException;
import org.json.JSONObject;

import java.util.HashMap;
import java.util.Map;

public class RegisterPage extends AppCompatActivity {

    public static final String EXTRA_USERNAME = "com.TrainingTime.application.TrainingTime.EXTRA_USERNAME";
    public static final String EXTRA_USERID = "com.TrainingTime.application.TrainingTime.EXTRA_USERID";
    public static final String EXTRA_PASSWORD = "com.TrainingTime.application.TrainingTime.EXTRA_PASSWORD";
    public static final String EXTRA_SEAT = "com.TrainingTime.application.TrainingTime.EXTRA_SEAT";
    public static final String EXTRA_SPINNER1 = "com.TrainingTime.application.TrainingTime.EXTRA_SpINNER1";
    public static final String EXTRA_SPINNER2 = "com.TrainingTime.application.TrainingTime.EXTRA_SPINNER2";

    private EditText UserName, UserID, Password, Password2;
    private Button Button1, Return;
    private TextView info;
    private EditText seat;

    private Spinner spin1, spin2;

    String[] course = {"I", "M", "S"};
    String[] year ={"1", "2", "3", "4", "5"};

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_register_page);

        UserName = findViewById(R.id.UserName);
        UserID = findViewById(R.id.UserID);
        Password = findViewById(R.id.Password);
        Password2 = findViewById(R.id.Password2);
        info = findViewById(R.id.TextView2);
        Button1 = findViewById(R.id.RegisButton);
        Return = findViewById(R.id.Return);
        seat = findViewById(R.id.seat);
        spin1 = findViewById(R.id.gakka2);
        spin2 = findViewById(R.id.gakune2);


        populateSpinnerYear();
        populateSpinnerCourse();


        Button1.setOnClickListener(new View.OnClickListener(){
            @Override
            public void onClick(View view){

                openRegisterComfirm(UserName.getText().toString(),UserID.getText().toString(), seat.getText().toString(), Password.getText().toString(), Password2.getText().toString(), spin1.getSelectedItem().toString(), spin2.getSelectedItem().toString());
            }
        });

        Return.setOnClickListener(new View.OnClickListener(){
            @Override
            public void onClick(View view){
                Intent intent = new Intent(RegisterPage.this, MainActivity.class);
                startActivity(intent);
            }
        });


    }

    private void populateSpinnerCourse(){
        ArrayAdapter<String> bb = new ArrayAdapter<>(this,android.R.layout.simple_spinner_item,course);
        bb.setDropDownViewResource(android.R.layout.simple_spinner_dropdown_item);
        spin1.setAdapter(bb);

    }

    private void populateSpinnerYear(){
        ArrayAdapter<String> aa = new ArrayAdapter<>(this,android.R.layout.simple_spinner_item, year);
        aa.setDropDownViewResource(android.R.layout.simple_spinner_dropdown_item);
        spin2.setAdapter(aa);

    }

        @SuppressLint("SetTextI18n")
    public void openRegisterComfirm(String UserName, String UserId, String seat, String UserPassword, String Password2, String Spinner1, String Spinner2) {

        if("".equals(UserName) && "".equals(Spinner1) && "".equals(Spinner2)) {

            info.setText("全部記入してください。");

        }else if(UserPassword.length() < 6 || UserPassword.length() > 15){

            info.setText("パスワードは6桁以上15桁以内にしてください。");

        }else if(!UserPassword.equals(Password2)) {

            info.setText("パスワードは同じに入力してください。");

        }else if(seat.length() != 2){

            info.setText("1桁の出席番号は2桁で入力してください。");

        }else if(UserId.length() != 6  ){

            info.setText("ユーザー名は6桁にしてください。");

        }else{
            Intent intent = new Intent(RegisterPage.this, RegisterComfirmPage.class);
            intent.putExtra(EXTRA_USERNAME, UserName);
            intent.putExtra(EXTRA_USERID, UserId);
            intent.putExtra(EXTRA_PASSWORD, UserPassword);
            intent.putExtra(EXTRA_SEAT, seat);
            intent.putExtra(EXTRA_SPINNER1 , Spinner1);
            intent.putExtra(EXTRA_SPINNER2 , Spinner2);
            startActivity(intent);
            info.setText("");


        }

    }


}
