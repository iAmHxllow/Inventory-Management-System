<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile </title>
    <!-- ------style--------------- -->

    <style>
        *{
            padding: 0;
            margin: 0;
            box-sizing: border-box;
            overflow-x: hidden;
        }
        body{
           font-family: sans-serif; 
        }
        .body{
            margin-top: 100px;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
        }
    .body h1{
        color: #575DD3;
        font-size: 35px;
    }
    .contact{
        border: 2px solid #9496C2;
        margin-top: 20px;
      width: 452px;
      height: 410px;
      padding: 10px;
        display: block;
    }
    .contact h2{
        text-align: center;
        color: #575DD3;
    }
 
    .contact .button{
      
        display: flex;
        justify-content: center;
        flex-direction: column;
        align-items: center;
       
      
    }
    .button button{
        width: 320px;
        height: 60px;
        background-color: #A6A4F0;
        border: 2px solid #817FEE;
        color: #fff;
        font-size: 20px;
     margin-top: 20px;
        cursor: pointer;

        
    }
.vector_space{
    border: 2px solid #CFD1E4;
    padding: 80px 0px;
display: flex;
align-items: center;
justify-content: center;
    margin: 10px;
}
 .vector_space p{
position: absolute;
margin-bottom: -30px;
color: #575DD3;
font-weight: 600;
font-size: 18px;

 }
 .section{
    text-align: center;
    margin-top:20px;
    padding: 10px;
 }
 .section p{
    border: 1px solid #A6A4F0;
    padding: 7px;
    color: #575DD3; font-weight: 600;
 }
 form{
    padding: 10px;
 }
 form label{
    color: #575DD3;
    font-size: 16px;
    font-weight: 600;
 }

 form textarea{
    width: 100%;
    height: 150px;
    border: 2px solid #CFD1E4;
    outline: none;
 }
 form select{
    width: 200px;
    padding: 3px;
    color: #575DD3;
    outline: none;
    font-weight: 600;
font-size: 15px;
    border: 2px solid #CFD1E4;
 }
 form option{
    width: 200px;
    padding: 3px;
    border: 2px solid #CFD1E4;
    color: #575DD3;
font-weight: 600;
font-size: 15px;
 }
    </style>
</head>
<body>
    <div class="body">
    <!-- -----------header---------- -->
    <h1>Research Collaborative Engine</h1>
    <!-- --------------contact----------- -->
    <div class="contact">
        <h2>Profile </h2>
       


        </form>
       <div class="button">
       <a href="profile_edit.php"><button>Edit </button>
       <a href="add_publication.php"><button>Add Publication </button>
        <a href="main_page.php"><button>Main Page</button>
        <a href="login.php"><button>Log Out</button>
      
    </div>
</div>
</body>
</html