<script src="https://js.stripe.com/v3/"></script>
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<form action="" method="" id="stripe">
    <input type="text" name="cardNumber" id="cardNumber" placeholder="Card Number">
    <input type="text" name="cvv" id="cvv" placeholder="Card CVC">
    <input type="text" name="month" id="month" placeholder="Expiry month">
    <input type="text" name="year" id="year" placeholder="Eexpiry Year">
    <input type="submit" name="Submit" id="" value="Submit">
</form>

<div class="modal" id="myModal">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title"></h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        {{-- <form action="" class="form-horizontal">
            <div class="row">
                <div class="form-group col-6">
                    <label for="firstname" class="control-label">firstname</label>
                    <input type="text" class="form-control" placeholder="First name">
                </div>
                 <div class="form-group col-6">
                    <label for="firstname" class="control-label">lastname</label>
                    <input type="text" class="form-control" placeholder="last name">
                </div>
                <div class="form-group col-6">
                    <label for="firstname" class="control-label">E-mail</label>
                    <input type="text" class="form-control" placeholder="username@domain.com">
                </div>
                 <div class="form-group col-6">
                    <label for="firstname" class="control-label">Phone</label>
                    <input type="text" class="form-control" placeholder="Phone">
                </div>
                <div class="form-group">
                    <select name="" id="" class="form-control">
                        <option value="">Select Course</option>
                    </select>
                </div>
            </div>

        </form> --}}
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>

    </div>
  </div>
</div>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
<script type="text/javascript">
    var stripe = Stripe("pk_test_MU14CejbqE3dwNDh5wqs3HIo00s2O59up2");
    document.getElementById('stripe').addEventListener('submit', async function(){
        event.preventDefault();
        data={}
        data.cardNumber=document.getElementById('cardNumber').value;
        data.cvc=document.getElementById('cvv').value;
        data.month=document.getElementById('month').value;
        data.year=document.getElementById('year').value;
        console.log(data)
         fetch('http://localhost:8000/setup', {
          method: 'POST',
          body: JSON.stringify(data),
          headers: {
             "Content-type": "application/json; charset=UTF-8",
             'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(
            r=>r.json()
        ).then(r=>{
            if(r.next_action){
               // alert(r.client_secret)
              //  var iframe = document.createElement('iframe');
                window.location.href = r.next_action.redirect_to_url.url;
              //  iframe.width = 600;
              //  iframe.height = 400;
               // document.querySelector('.modal-body').appendChild(iframe);
              //  $('#myModal').modal('show')
               // stripe.handleCardAction(r.client_secret)
                // .then(r=>{
                //     console.log(r)
                // })
            }else{
                alert("not 3d secure");
            }
            console.log(r)
        })
    })

</script>
