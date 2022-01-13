( function() {    
    var vm = new Vue({
        el: document.querySelector('#mount'),
        data: {
            reviews: []
           },
        template: '<div><h2>Current reviews</h2>\
            <div>\
                <div class="review-item" v-for="review in reviews">\
                    <div class="review-field" v-for="(value, field) in review.acf">\
                        <div :class="field"><span class="init-value">{{value}}</span></div>\
                    </div>\
                    <div class="rejting-repl">\
                        <div class="green-stars">\
                            <span class="star" v-for="index in parseInt(review.acf.rejting)" :key="index">&#9733;</span>\
                        </div>\
                        <div class="gray-stars">\
                            <span class="star" v-for="index in parseInt(5 - review.acf.rejting)" :key="index">&#9733;</span>\
                        </div>\
                    </div>\
                </div>\
            </div></div>',
        methods:{
 
                fetchPosts: function(){
                  var url = 'https://masters-soft.com.ua/medicinadigruppospallanzani/wp-json/wp/v2/reviews';
                  fetch(url).then((response)=>{
                    return response.json()
                    }).then((data)=>{
                      this.reviews = data;
                      //rateTransform()                                            
                    });
                }
               },
        mounted: function() {
                console.log("Component is mounted");
              
                this.fetchPosts();
                setInterval(function () {
                 this.fetchPosts();                 
                }.bind(this), 3000);                
              }

       });    
   })();
