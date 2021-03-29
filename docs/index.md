<p style = "text-align: center;">Team 14 - Periklis Ntinos, WeiJian Xu, Leon Yao</p>



### Week 16 (22/03/2021 - 28/03/2021)

### Week 15 (15/03/2021 - 21/03/2021)

### Week 14 (08/03/2021 - 14/03/2021)

### Week 13 (01/03/2021 - 07/03/2021)

### Week 12 (22/02/2021 - 28/02/2021)
<p style = "text-align: justify">
Functional fetching of posts from the CMS, utilizing the <i>Axios</i> library of <i>React Native</i>. The response is 
an array of objects in JavaScript Object Notation (JSON). 
</p>

```JSX
const [posts, setPosts] = React.useState([]);

React.useEffect(() => {
    Axios.get('http://arthurmurraydcp.com/wp-json/wp/v2/posts').then(response => {
        setPosts(response.data);
    });
}, [setPosts]);
```

### Week 11 (15/02/2021 - 21/02/2021)

### Week 10 (08/02/2021 - 14/02/2021)

### Week 9 (01/02/2021 - 07/02/2021)

### Week 8 (25/01/2021 - 31/01/2021)

### Week 7 (18/01/2021 - 24/01/2021)
<p style = "text-align: justify">
Focus on finding a suitable web host for the content management system (CMS). Initially, Microsoft Azure Virtual Machine was used, 
however the connection to the VM was unstable and the contents of the CMS could not be rendered correctly. As a result, we decided 
to purchase a domain from <i>GoDaddy</i> and store the content in a server based in Hong Kong. We transferred the CMS to the new 
server and the content could be viewed properly, with consistent uptime and a stable connection.
</p>

### Week 6 (11/01/2021 - 17/01/2021)
Elevator Pitch (15/01): Presentation of the main technical features of the project.


### Week 5 (14/12/2020 - 20/12/2020)

### Week 4 (07/12/2020 - 13/12/2020)

### Week 3 (30/11/2020 - 06/12/2020)

### Week 2 (23/11/2020 - 29/11/2020)

### Week 1 (16/11/2020 - 22/11/2020)
