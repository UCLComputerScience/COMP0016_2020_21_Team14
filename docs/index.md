<p style = "text-align: center;">Team 14 - Periklis Ntinos, WeiJian Xu, Leon Yao</p>



### Week 16 (22/03/2021 - 28/03/2021)
<p style = "text-align: justify">
Final changes to the Portfolio entries and submission of necessary material. Code handover to clients. Review of finalized
content and submission for marking.
</p>

### Week 15 (15/03/2021 - 21/03/2021)
<p style = "text-align: justify">
Final modifications to the iOS application and the CMS. Code review with TA and clients to discuss the developed product,
explain the code and its main functionalities and confirm that the requirements have been met.
</p>

<b>MoSCoW List:</b>

|  ID   |               Requirement               | Priority | Achieved |
| :---: | :-------------------------------------: | :------: | :------: |
|   1   | iOS Application (view)                  |   Must   |    Y     |
|   2   | Content Management System (view/upload) |   Must   |    Y     |
|   3   | Music Suggestions                       |  Should  |    Y     |
|   4   | Apple Watch + HealthKit Integration     |  Could   |    N     |
|   5   | Livestream Functionality                |  Could   |    N     |

### Week 14 (08/03/2021 - 14/03/2021)
<p style = "text-align: justify">
Extensive testing of the iOS application to ensure consistent runtime, efficient fetching of required data from the CMS
and elimination of bugs and errors.
</p>

### Week 13 (01/03/2021 - 07/03/2021)
<p style = "text-align: justify">
Start of development for the static report website. Tutorials on static websites were followed to determine the best way
to implement the required functionality and achieve the desired result.
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
Addition of requested functionality to iOS application and continuous improvements on the user interface. Further modifications
to the CMS. Preparation of Prototype 2 to be shared with TA and clients for feedback.
</p>

### Week 10 (08/02/2021 - 14/02/2021)
<p style = "text-align: justify">
Comparison of the two applications built in <i>React Native</i> and <i>Swift</i>.  Final decision to not proceed further with
<i>Swift</i> and use <i>React Native</i>, which was our initial choice and more progress had been made.
</p>

### Week 9 (01/02/2021 - 07/02/2021)
<p style = "text-align: justify">
Second evaluation of <i>Swift</i> to develop the iOS application, due to problems faced when learning <i>React Native</i>. Various
tutorials were followed and template applications were built using <i>Xcode</i>.
</p>

### Week 8 (25/01/2021 - 31/01/2021)
<p style = "text-align: justify">
Prototype 1 of the CMS and iOS application was shared with the clients for feedback. Changes on visual aspects for both components.
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
and <i>React Native</i>. Investigation on proposed architectural designs, concerning necessary data structures and algorithms.
</p>

### Week 3 (30/11/2020 - 06/12/2020)
<p style = "text-align: justify">
Research on existing solutions for the proposed project. <i>Snapp Dance</i> was suggested by the clients to act as a guide for the
iOS application, in terms of functionality and user interface. Discussion of key differences between existing and proposed solution.
Construction of interactive wireframes to visualize the functionality and user interface of the proposed solution for both the CMS
and the iOS application.
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
