import React from 'react';
import { StyleSheet, View } from 'react-native';
import { DrawerContentScrollView, DrawerItem } from '@react-navigation/drawer';
import { Avatar, Title, Caption, Paragraph, Drawer, Text, TouchableRipple, Switch } from 'react-native-paper';
import Icon from 'react-native-vector-icons/MaterialCommunityIcons';
import AsyncStorage from '@react-native-async-storage/async-storage';

var name = '';

const asyncGet = async (key) => {
    try {
        const result = await AsyncStorage.getItem(key);
        name = JSON.parse(result);
    } catch(error) {
        console.log(error);
    }
}

export function DrawerContent(props) {
    asyncGet('name');
    
    return (
        <View style = {{flex: 1}}>
            <DrawerContentScrollView {...props}>
                <View style = {styles.drawerContent}>
                    <View style = {styles.userInfoSection}>
                        <View style = {{flexDirection: 'row', marginTop: 15}}>
                            <Avatar.Image
                                source = {{uri: 'https://icon-library.com/images/avatar-icon-images/avatar-icon-images-4.jpg'}}
                                size = {50}
                            />
                            <View style = {{marginLeft: 15, flexDirection: 'column'}}>
                                <Title style = {styles.title}>{name}</Title>
                            </View>
                        </View>
                    </View>
                    <Drawer.Section style = {styles.drawerSection}>
                        <DrawerItem
                            icon = {({color, size}) => (
                                <Icon
                                    name = "home-outline"
                                    color = {color}
                                    size = {size}
                                />
                            )}
                            label = "Home"
                            onPress = {() => {props.navigation.navigate('Home')}}
                        />
                        <DrawerItem
                            icon = {({color, size}) => (
                                <Icon
                                    name = "music-note-outline"
                                    color = {color}
                                    size = {size}
                                />
                            )}
                            label = "Music"
                            onPress = {() => {props.navigation.navigate('Music')}}
                        />
                    </Drawer.Section>
                </View>
            </DrawerContentScrollView>
            <Drawer.Section style = {styles.bottomDrawerSection}>
                <DrawerItem
                    icon = {({color, size}) => (
                        <Icon
                            name = "exit-to-app"
                            color = {color}
                            size = {size}
                        />
                    )}
                    label = "Sign Out"
                    onPress = {async () => {
                        await AsyncStorage.removeItem('token');
                        await AsyncStorage.removeItem('name');
                        await AsyncStorage.removeItem('email');
                        props.navigation.navigate('Login');
                    }}
                />
            </Drawer.Section>
        </View>
    );
}

const styles = StyleSheet.create({
    drawerContent: {
        flex: 1,
    },
    userInfoSection: {
        paddingLeft: 20,
    },
    title: {
        fontSize: 16,
        marginTop: 10,
        fontWeight: 'bold',
    },
    caption: {
        fontSize: 14,
        lineHeight: 14,
    },
    row: {
        marginTop: 20,
        flexDirection: 'row',
        alignItems: 'center',
    },
    section: {
        flexDirection: 'row',
        alignItems: 'center',
        marginRight: 15,
    },
    paragraph: {
        fontWeight: 'bold',
        marginRight: 3,
    },
    drawerSection: {
        marginTop: 15,
    },
    bottomDrawerSection: {
        marginBottom: 0,
        borderTopColor: '#f4f4f4',
        borderTopWidth: 1
    },
    preference: {
        flexDirection: 'row',
        justifyContent: 'space-between',
        paddingVertical: 12,
        paddingHorizontal: 16,
    }
});
