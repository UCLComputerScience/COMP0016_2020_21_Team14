import React from 'react';
import {View} from 'react-native';

import Posts from '../components/Posts';

const Home = ({navigation}) => {
    return (
        <View style = {{flex: 1, backgroundColor: '#E7CFC8'}}>
            <Posts navigation = {navigation} screen = {'Home'}/>
        </View>
    );
}

export default Home;
