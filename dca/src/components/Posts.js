import React from 'react';
import {View, Image, FlatList, TouchableOpacity, StyleSheet} from 'react-native';
import {Card, Title} from 'react-native-paper';
import HTML from 'react-native-render-html';
import Axios from 'axios';

const Posts = ({navigation, screen}) => {
    const [posts, setPosts] = React.useState([]);

    React.useEffect(() => {
        Axios.get('http://arthurmurraydcp.com/wp-json/wp/v2/posts').then(response => {
            setPosts(response.data);
        });
    }, [setPosts]);

    const dancePosts = posts.filter(item => item.categories.includes(1));
    const musicPosts = posts.filter(item => item.categories.includes(53));

    return (
        <View style = {styles.container}>
            <FlatList
                keyExtractor = {item => item.id.toString()}
                data = {screen == 'Home' ? dancePosts : musicPosts}
                ListHeaderComponent = {
                    <Image
                        style = {styles.image}
                        source = {require('../../assets/logo.png')}
                    />
                }
                renderItem = {({item}) => (
                    <TouchableOpacity onPress = {() => {navigation.navigate('Post', {id: item.id})}} activeOpacity = {0.9}>
                        <Card style = {styles.card}>
                            <Card.Content>
                                <Title style = {styles.title}><HTML source = {{html: item.title.rendered}}/></Title>
                            </Card.Content>
                            <Card.Cover source = {{uri: item.featured_media_src_url}}/>
                        </Card>
                    </TouchableOpacity>
                )}
            />
        </View>
    );
}

export default Posts;

const styles = StyleSheet.create({
    container: {
        flex: 1
    },
    card: {
        width: '90%',
        alignSelf: 'center',
        backgroundColor: '#FFFFFF',
        marginVertical: 10
    },
    title: {
        alignSelf: 'center'
    },
    image: {
        width: 420, height: 90,
        resizeMode: "contain"
    }
});
