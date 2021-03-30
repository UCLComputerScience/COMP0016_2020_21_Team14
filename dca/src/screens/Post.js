import React from 'react';
import { View, ScrollView, Image, FlatList, TouchableOpacity, StyleSheet } from 'react-native';
import { Avatar, Button, Card, Title, Paragraph, List } from 'react-native-paper';
import { IGNORED_TAGS } from 'react-native-render-html/src/HTMLUtils';
import { WebView } from 'react-native-webview';
import HTML from 'react-native-render-html';
import Axios from 'axios';

const Post = ({route}) => {
    const {id} = route.params;
    const [post, setPost] = React.useState([]);

    const INJECTEDJAVASCRIPT =
            `const meta = document.createElement('meta');
            meta.setAttribute('content', 'width=device-width, initial-scale=0.5, maximum-scale=0.5, user-scalable=0');
            meta.setAttribute('name', 'viewport'); document.getElementsByTagName('head')[0].appendChild(meta);`
        ;

    React.useEffect(() => {
        Axios.get(`http://arthurmurraydcp.com/wp-json/wp/v2/posts?&include=${id}`).then(response => {
            setPost(response.data);
        });
    }, [setPost]);

    return (
        <View style = {styles.container}>
            <FlatList
                data = {post}
                keyExtractor = {item => item.id.toString()}
                renderItem = {({item}) => (
                    <Card style = {{backgroundColor: 'rgba(231, 207, 200, 0.9)'}}>
                        <Card.Content>
                            <Title style = {{alignSelf:'center'}}> <HTML source={{html: item.title.rendered}}/></Title>
                            <Paragraph />
                        </Card.Content>
                        <Card.Content>
                            <HTML
                                ignoredTags={IGNORED_TAGS.filter(tag => tag !== 'video')}
                                source = {{html: item.content.rendered}}
                                renderers={{
                                    video: (htmlAttribs, children, convertedCSSStyles, passProps) => {
                                        return <View key={passProps.key} style={{ width: "100%", aspectRatio:16.0/9.0, marginTop:16, marginBottom:16 }}>
                                            <WebView
                                                scrollEnabled={false}
                                                mediaPlaybackRequiresUserAction={true}
                                                allowsInlineMediaPlayback={true}
                                                javaScriptEnabled={true}
                                                scalesPageToFit={false}
                                                allowsFullscreenVideo={true}
                                                domStorageEnabled={true}
                                                allowFileAccess={false}
                                                source = {{ html: `
                                                <video width="100%" height="100%" controls>
                                                    <source src="${htmlAttribs.src}" type="video/mp4">
                                                </video>
                                                ` }}
                                                style={{ flex: 1, width: "100%", aspectRatio: 16.0 / 9.0 }}
                                            />
                                        </View>
                                    },
                                    iframe: (htmlAttribs, children, convertedCSSStyles, passProps) => {
                                        return <View key={passProps.key} style={{ width: "100%", aspectRatio:16.0/9.0, marginTop:16, marginBottom:16 }}>
                                            <WebView
                                                scrollEnabled={false}
                                                mediaPlaybackRequiresUserAction={true}
                                                allowsInlineMediaPlayback={true}
                                                javaScriptEnabled={true}
                                                injectedJavaScript={INJECTEDJAVASCRIPT}
                                                onMessage={() => {}}
                                                scalesPageToFit={false}
                                                allowsFullscreenVideo={true}
                                                domStorageEnabled={true}
                                                allowFileAccess={false}
                                                source={{ uri: htmlAttribs.src }}
                                                style={{ flex: 1, width: "100%", aspectRatio: 16.0 / 9.0 }}
                                            />
                                        </View>
                                    }
                                }}
                            />
                        </Card.Content>
                    </Card>
                )}
            />
        </View>
    );
}

export default Post;

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
        textAlign: 'center'
    },
    image: {
        width: 420, height: 90,
        resizeMode: "contain"
    }
});
