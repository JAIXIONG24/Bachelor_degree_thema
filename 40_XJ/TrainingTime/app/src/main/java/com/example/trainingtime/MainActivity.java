package com.example.trainingtime;

import androidx.appcompat.app.AppCompatActivity;

import android.content.Intent;
import android.os.Bundle;
import android.view.View;
import android.widget.Button;

public class MainActivity extends AppCompatActivity {
 Button RegisButton,LoginButton;


//    public void init(){
//        RegisButton = findViewById(R.id.RegisButton);
//        LoginButton = findViewById(R.id.LoginButton);
//
//
//
////        RegisButton.setOnClickListener(new View.OnClickListener(){
////            @Override
////            public void onClick(View v) {
////                Intent intent = new Intent(MainActivity.this, RegisterPage.class);
////                startActivity(intent);
////            }
////        });
////
////
////        LoginButton.setOnClickListener(new View.OnClickListener(){
////            @Override
////            public void onClick(View v) {
////                Intent toy = new Intent(MainActivity.this,LoginPage.class);
////                startActivity(toy);
////            }
////        });
//    }

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);

        RegisButton = findViewById(R.id.RegisButton);
        LoginButton = findViewById(R.id.LoginButton);

        //init();
        RegisButton.setOnClickListener(new View.OnClickListener(){
            @Override
            public void onClick(View v) {
                Intent intent = new Intent(MainActivity.this, RegisterPage.class);
                startActivity(intent);
            }
        });


        LoginButton.setOnClickListener(new View.OnClickListener(){
            @Override
            public void onClick(View v) {
                Intent toy = new Intent(MainActivity.this,LoginPage.class);
                startActivity(toy);
            }
        });
    }
}