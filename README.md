<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>


<img width="1364" alt="Server Sent Events in Laravel and OpenAI API" src="https://github.com/bhaidar/laravel-server-sent-events/assets/1163421/5e14721f-7d33-4673-bcc3-e97644811391">


# Server-Sent Events Integration in Laravel Application

This repository showcases the utilization of server-sent events within a Laravel application, emphasizing the seamless integration of the OpenAI API for real-time chat streaming.

## Project Overview

The focal point of this project is the development of a streamlined chat interface, harmonizing the dynamic interaction between users and the OpenAI API through the utilization of server-sent events. The application's core functionality revolves around users posing inquiries, to which OpenAI furnishes responses. This exchange of information is achieved through the continuous streaming of responses, employing the server-sent events capability.

## Local Deployment

To experience this application firsthand on your local machine, you can follow these steps:

1. **Clone Repository**: Begin by cloning this repository to your local environment.

2. **Install Dependencies**: Utilize the `composer` package manager to install all essential PHP dependencies.

3. **Local Environment Setup**: With the aid of Laravel Sail, this application can be readily set up and executed locally. Ensure that Docker is installed on your system. Then, proceed with the subsequent commands:
   ```
   sail up -d
   sail npm install
   sail npm run dev
   ```

## Disclaimer

It's important to note that this application exclusively serves as a demonstration, thereby rendering it unsuitable for deployment in a production environment.

## Contact Information

Should you be interested in further exploring similar projects for potential production applications, feel free to get in touch with me at: bhaidar@gmail.com.

We hope you find this demonstration both informative and insightful. Thank you for your interest and exploration!
