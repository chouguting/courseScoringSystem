# courseScoringSystem
# NTOU CSE 資料庫系統期末專案



## **課程評分系統**
![image](https://user-images.githubusercontent.com/22258475/187892669-16394131-966f-4daa-bee7-544f61e5d320.png)



### 系統功能介紹

本次資料庫系統的專案我們是要做課程的打分系統，有鑒於本校的教務系統沒有這麼好選課，所以我們提出一個全新的平台方便學生可以查詢課程，並且帶有一個評分機制能讓學生做出正確的決定，除此之外還有留言功能讓大家留下心得體驗。

除此之外，我們還有登入管理機制，也有管理員系統，能維持一個相對和平的交流環境。

## 資料庫ER-Diagram

![image](https://user-images.githubusercontent.com/22258475/187892209-5b8dba8c-a280-4827-8661-9e31aa51de82.png)

### 系統中的表格定義與正規型式分析

#### **user表格**

create table user

(

`    `user\_id      int(30) auto\_increment

`        `primary key,

`    `username     varchar(30) not null,

`    `display\_name varchar(30) not null,

`    `password     varchar(30) not null,

`    `user\_level   char        not null,

`    `constraint username

`        `unique (username)

)

`    `charset = utf8;

user\_id是自動生成的，每個人在註冊時都會得到一組，因此它一定能決定獨特的一個row

username是用戶註冊時用的帳號，他不能重複(有unique)，它也能決定獨特的user\_id,display\_name, password和user\_level

所以F={ user\_id → user\_id, username, display\_name, password , user\_level,

`		  `Username → user\_id, display\_name, password , user\_level }

F中每一個α都是superkey 因此符合 BCNF



#### **department表格**

create table department

(

`    `department\_name    varchar(30)   not null

`        `primary key,

`    `department\_website varchar(70)   null,

`    `instructor\_count   int default 0 not null

)

`    `charset = utf8;

department\_name決定了department\_website和instructor\_count，也只有它能決定其他屬性

: F={department\_name→department\_website , instructor\_count}

department\_name也是一個primary key ，理所當然也是super key，因此符合BCNF

#### **course表格**

create table course

(

`    `course\_id       varchar(20) not null,

`    `course\_name     varchar(20) not null,

`    `course\_status   varchar(3)  not null,

`    `semester        varchar(3)  null,

`    `instructor\_id   int(30)     not null,

`    `department\_name varchar(20) null,

`    `course\_location varchar(20) null,

`    `course\_time     varchar(20) null,

`    `primary key (course\_id, instructor\_id),

`    `constraint course\_ibfk\_1

`        `foreign key (instructor\_id) references instructor (instructor\_id),

`    `constraint course\_ibfk\_2

`        `foreign key (department\_name) references department (department\_name)

)

`    `charset = utf8;

course\_id決定了其他屬性(包括課名,老師,學期,開課狀態,時間,地點…)，也只有它能(開設課程的學系跟老師屬於哪個系是無關的)

: F={course\_id→course\_name , course\_status, semester, instructor\_id , department\_name, course\_location , course\_time }

course \_id也是一個candidate key，理所當然也是super key，因此符合BCNF

#### **instructor表格**

create table instructor

(

`    `instructor\_id   int(30) auto\_increment

`        `primary key,

`    `instructor\_name varchar(20) not null,

`    `department\_name varchar(20) null,

`    `constraint instructor\_ibfk\_1

`        `foreign key (department\_name) references department (department\_name)

)

`    `charset = utf8;

instructor\_id決定了老師叫什麼（instructor\_name）和所屬學系(department\_name)，也只有它能: F={instructor\_id→instructor\_name , department\_name }

instructor \_id也是一個candidate key，理所當然也是super key，因此符合BCNF

#### **rating表格**

create table rating

(

`    `rating      decimal(2)                            not null,

`    `impression  varchar(500)                          null,

`    `course\_id   varchar(20)                           not null,

`    `user\_id     int(30)                               not null,

`    `rating\_time timestamp default current\_timestamp() not null on update current\_timestamp(),

`    `primary key (user\_id, course\_id),

`    `constraint rating\_ibfk\_1

`        `foreign key (course\_id) references course (course\_id)

`            `on delete cascade,

`    `constraint rating\_ibfk\_2

`        `foreign key (user\_id) references user (user\_id)

`            `on delete cascade

)

`    `charset = utf8;

(user\_id,course\_id)決定了獨特的評論，能獨特的決定impression,rating\_time及rating(一個用戶在一堂課只能評分一次)

: F={ user\_id, course\_id→impression ,rating\_time ,rating}

(user\_id,course\_id) 也是一個candidate key，理所當然也是super key，因此符合BCNF


