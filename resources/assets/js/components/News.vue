<template>
    <div class="column column-12">
        <div class="panel" id="news">
            <div class="content">
                <div class="title"><i class="fa fa-newspaper-o" aria-hidden="true"></i> Tweakers nieuws</div>
                <div class="news-items">
                    <div class="news-item" v-for="item in news">
                        <a class="news-title" :href="item.link">{{ item.title }}</a>
                        <p class="news-description">{{ item.description }}</p>
                        <div class="news-category">Categorie: {{ item.category }}</div>
                        <small>Gepubliceerd op: {{ item.date }}</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    let data = {
        news: []
    };

    function stripHtml(html) {
        let div = document.createElement("div");
        html = html.replace(/<img.*>/);
        div.innerHTML = html;

        return div.textContent || div.innerText || "";
    }

    function getNews() {
        axios.get('/api/news')
            .then(function(response) {
                let responseData = response.data;

                if (responseData.message !== "") {
                    console.log(payload.message);
                } else {
                    let payload = responseData.payload;
                    let items = payload.channel.item.slice(0, 3);
                    let parsedItems = [];

                    for (let i = 0; i < items.length; i++) {
                        let item = items[i];
                        let parsedItem = {};

                        parsedItem.link = item.link;
                        parsedItem.title = item.title;
                        parsedItem.category = item.category;
                        parsedItem.description = stripHtml(item.description).substr(0, 150) + "...";
                        parsedItem.date = moment(item.pubDate).locale('nl').format('D MMMM YYYY, HH:mm:ss');

                        parsedItems.push(parsedItem);
                    }

                    data.news = parsedItems;
                }
            })
            .catch(function (error) {
                console.log(error);
            });
    }


    setInterval(getNews, 10000);
    getNews();

    export default {
        data: function () {
            return data
        },
        mounted() {
            console.log('News component mounted.')
        }
    }
</script>