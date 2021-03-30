<p style = "text-align: center;">Team 14 - Periklis Ntinos, WeiJian Xu, Leon Yao</p>



### Week 16 (22/03/2021 - 28/03/2021)
<p style = "text-align: justify">
</p>

### Week 15 (15/03/2021 - 21/03/2021)
<p style = "text-align: justify">
</p>

### Week 14 (08/03/2021 - 14/03/2021)
<p style = "text-align: justify">
</p>

### Week 13 (01/03/2021 - 07/03/2021)
<p style = "text-align: justify">
</p>

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
<p style = "text-align: justify">
</p>

### Week 10 (08/02/2021 - 14/02/2021)
<p style = "text-align: justify">
</p>

### Week 9 (01/02/2021 - 07/02/2021)
<p style = "text-align: justify">
</p>

### Week 8 (25/01/2021 - 31/01/2021)
<p style = "text-align: justify">
</p>

### Week 7 (18/01/2021 - 24/01/2021)
<p style = "text-align: justify">
Focus on finding a suitable web host for the content management system (CMS). Initially, Microsoft Azure Virtual Machine was used,
however the connection to the VM was unstable and the contents of the CMS could not be rendered correctly. As a result, we decided
to purchase a domain from <i>GoDaddy</i> and store the content in a server based in Hong Kong. We transferred the CMS to the new
server and the content could be viewed properly, with consistent uptime and a stable connection.
</p>

### Week 6 (11/01/2021 - 17/01/2021)
<p style = "text-align: justify">
Elevator Pitch (15/01): Presentation of the main technical features of the project.
</p>

### Week 5 (14/12/2020 - 20/12/2020)
<p style = "text-align: justify">
Decision to use <i>React Native</i> for the development of the iOS application. The Progressive Web Application (PWA) was rejected
because the resulting application would not have a native feel and would feel as if a web-browser is being used to access it.
<i>Swift</i> was rejected due to its steep learning curve, which could result in a poorly developed application in the limited time
available. Overall, <i>React Native</i> appears to be the best choice for this project, providing a middle ground in terms of
difficulty, code efficiency and user-centered design.
</p>

### Week 4 (07/12/2020 - 13/12/2020)
<p style = "text-align: justify">
Discussion of possible implementations and appropriate tools/technologies to be used for the completion of the project. Concerning
the iOS application, an investigation will follow to determine the best route among a Progressive Web Application (PWA), <i>Swift</i>
and <i>React Native</i>.
</p>

### Week 3 (30/11/2020 - 06/12/2020)
<p style = "text-align: justify">
Research on existing solutions for the proposed project. _Snapp Dance_ was suggested by the clients to act as a guide for the iOS
application, in terms of functionality and user interface. Discussion of key differences between existing and proposed solution.
</p>

### Week 2 (23/11/2020 - 29/11/2020)
<p style = "text-align: justify">
Meeting with clients to discuss the project in depth and confirm their requirements. Confirmation of a MoSCoW requirement list with
clients. Discussion of requirements with TA and investigation on possible implementations.
</p>

<b>MoSCoW List:</b>
|  ID   |               Requirement               | Priority |
| :---: | :-------------------------------------: | :------: |
|   1   | iOS Application (view)                  |   Must   |
|   2   | Content Management System (view/upload) |   Must   |
|   3   | Music Suggestions                       |  Should  |
|   4   | Apple Watch + HealthKit Integration     |  Could   |
|   5   | Livestream Functionality                |  Could   |

### Week 1 (16/11/2020 - 22/11/2020)
<p style = "text-align: justify">
First meeting with TA, discussion of project and potential implementations.
</p>
